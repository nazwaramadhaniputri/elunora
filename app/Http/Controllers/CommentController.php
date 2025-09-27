<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $user = $request->user();
        abort_unless($user, 403);

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:2000'],
        ]);

        // Build attributes for insert, supporting both modern (name/content)
        // and legacy (nama/isi) schemas depending on existing columns
        $attrs = [
            'post_id' => $post->id,
            'name'    => $user->name ?? 'Pengguna',
            'email'   => $user->email ?? null,
            'content' => $validated['content'],
        ];

        if (Schema::hasColumn('comments', 'user_id')) {
            $attrs['user_id'] = $user->id ?? null;
        }

        if (Schema::hasColumn('comments', 'nama')) {
            $attrs['nama'] = $user->name ?? 'Pengguna';
        }
        if (Schema::hasColumn('comments', 'isi')) {
            $attrs['isi'] = $validated['content'];
        }
        if (Schema::hasColumn('comments', 'komentar')) {
            $attrs['komentar'] = $validated['content'];
        }

        $comment = new Comment($attrs);
        $comment->save();

        return back()->with('success', 'Komentar Anda berhasil dikirim.');
    }
}
