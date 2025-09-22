<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\FotoComment;
use Illuminate\Http\Request;

class FotoInteractionController extends Controller
{
    public function incrementLike(Foto $foto)
    {
        try {
            // Atomic increment
            $foto->increment('likes_count');
            $foto->refresh();
            return response()->json([
                'success' => true,
                'foto_id' => $foto->id,
                'likes_count' => (int) $foto->likes_count,
            ]);
        } catch (\Throwable $e) {
            $hint = str_contains($e->getMessage(), 'likes_count')
                ? 'Kolom likes_count belum ada. Jalankan: php artisan migrate'
                : null;
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
            $current = (int) ($foto->likes_count ?? 0);
            if ($current > 0) {
                $foto->decrement('likes_count');
            }
            $foto->refresh();
            return response()->json([
                'success' => true,
                'foto_id' => $foto->id,
                'likes_count' => (int) $foto->likes_count,
            ]);
        } catch (\Throwable $e) {
            $hint = str_contains($e->getMessage(), 'likes_count')
                ? 'Kolom likes_count belum ada. Jalankan: php artisan migrate'
                : null;
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
            $fotos = Foto::whereIn('id', $ids)->withCount('comments')->get(['id', 'likes_count']);
            $data = [];
            foreach ($fotos as $f) {
                $data[$f->id] = [
                    'likes_count' => (int) ($f->likes_count ?? 0),
                    'comments_count' => (int) ($f->comments_count ?? 0),
                ];
            }
            return response()->json(['data' => $data]);
        } catch (\Throwable $e) {
            $hint = str_contains($e->getMessage(), 'foto_comments') || str_contains($e->getMessage(), 'comments')
                ? 'Tabel foto_comments belum ada. Jalankan: php artisan migrate'
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
            $comment = new FotoComment();
            $comment->foto_id = $foto->id;
            $comment->content = $validated['content'];
            $comment->guest_name = $validated['guest_name'] ?? null;
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
