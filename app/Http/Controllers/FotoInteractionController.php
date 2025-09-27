<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\FotoComment;
use App\Models\FotoLike;
use Illuminate\Http\Request;

class FotoInteractionController extends Controller
{
    public function incrementLike(Foto $foto)
    {
        try {
            $user = request()->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
            }
            // Create per-user like (idempotent)
            FotoLike::firstOrCreate([
                'foto_id' => $foto->id,
                'user_id' => $user->id,
            ]);
            $likesCount = FotoLike::where('foto_id', $foto->id)->count();
            return response()->json([
                'success' => true,
                'foto_id' => $foto->id,
                'likes_count' => (int) $likesCount,
            ]);
        } catch (\Throwable $e) {
            $hint = str_contains($e->getMessage(), 'foto_likes') ? 'Tabel foto_likes belum ada. Jalankan: php artisan migrate' : null;
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyukai foto',
                'error' => $e->getMessage(),
                'hint' => $hint,
            ], 422);
        }

    }

    public function decrementLike(Foto $foto)
    {
        try {
            $user = request()->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
            }
            FotoLike::where('foto_id', $foto->id)->where('user_id', $user->id)->delete();
            $likesCount = FotoLike::where('foto_id', $foto->id)->count();
            return response()->json([
                'success' => true,
                'foto_id' => $foto->id,
                'likes_count' => (int) $likesCount,
            ]);
        } catch (\Throwable $e) {
            $hint = str_contains($e->getMessage(), 'foto_likes') ? 'Tabel foto_likes belum ada. Jalankan: php artisan migrate' : null;
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengurangi like',
                'error' => $e->getMessage(),
                'hint' => $hint,
            ], 422);
        }
    }

    public function getCounts(Request $request)
    {
        try {
            $ids = array_filter(array_map('intval', explode(',', (string) $request->query('ids'))));
            if (empty($ids)) {
                return response()->json(['data' => []]);
            }
            $fotos = Foto::whereIn('id', $ids)->withCount('comments')->get(['id']);
            $likesByFoto = FotoLike::whereIn('foto_id', $ids)
                ->selectRaw('foto_id, COUNT(*) as c')
                ->groupBy('foto_id')
                ->pluck('c', 'foto_id');
            $data = [];
            foreach ($fotos as $f) {
                $data[$f->id] = [
                    'likes_count' => (int) ($likesByFoto[$f->id] ?? 0),
                    'comments_count' => (int) ($f->comments_count ?? 0),
                ];
            }
            return response()->json(['data' => $data]);
        } catch (\Throwable $e) {
            $hint = str_contains($e->getMessage(), 'foto_comments') || str_contains($e->getMessage(), 'comments')
                ? 'Tabel foto_comments/foto_likes belum ada. Jalankan: php artisan migrate'
                : null;
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data',
                'error' => $e->getMessage(),
                'hint' => $hint,
            ], 422);
        }
    }

    public function listComments(Foto $foto)
    {
        try {
            $comments = $foto->comments()->latest()->take(50)->get(['id', 'content', 'guest_name', 'created_at']);
            return response()->json([
                'foto_id' => $foto->id,
                'comments' => $comments,
            ]);
        } catch (\Throwable $e) {
            $hint = str_contains($e->getMessage(), 'foto_comments')
                ? 'Tabel foto_comments belum ada. Jalankan: php artisan migrate'
                : null;
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil komentar',
                'error' => $e->getMessage(),
                'hint' => $hint,
            ], 422);
        }
    }

    public function addComment(Request $request, Foto $foto)
    {
        try {
            $validated = $request->validate([
                'content' => 'required|string|max:1000',
                'guest_name' => 'nullable|string|max:100',
            ]);
            $user = $request->user();
            $comment = new FotoComment();
            $comment->foto_id = $foto->id;
            $comment->content = $validated['content'];
            // If user is logged in, use their name; otherwise use provided guest_name or default to 'Tamu'
            $comment->guest_name = $user && $user->name
                ? $user->name
                : ($validated['guest_name'] ?? 'Tamu');
            $comment->guest_ip = $request->ip();
            $comment->save();

            return response()->json([
                'success' => true,
                'foto_id' => $foto->id,
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'guest_name' => $comment->guest_name,
                    'created_at' => $comment->created_at->toDateTimeString(),
                ],
                'comments_count' => $foto->comments()->count(),
            ], 201);
        } catch (\Throwable $e) {
            $hint = str_contains($e->getMessage(), 'foto_comments')
                ? 'Tabel foto_comments belum ada. Jalankan: php artisan migrate'
                : null;
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan komentar',
                'error' => $e->getMessage(),
                'hint' => $hint,
            ], 422);
        }
    }
}
