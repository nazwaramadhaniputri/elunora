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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'content' => ['required', 'string', 'max:2000'],
        ]);

        // Build attributes for insert, supporting both modern (name/content)
        // and legacy (nama/isi) schemas depending on existing columns
        $attrs = [
            'post_id' => $post->id,
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'content' => $validated['content'],
        ];

        if (Schema::hasColumn('comments', 'nama')) {
            $attrs['nama'] = $validated['name'];
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
