<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'name',      // modern schema
        'email',
        'content',   // modern schema
        // legacy columns for compatibility
        'nama',
        'komentar',
        'isi',
    ];
}
