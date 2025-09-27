<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoLike extends Model
{
    use HasFactory;

    protected $table = 'foto_likes';

    protected $fillable = [
        'foto_id',
        'user_id',
    ];

    public function foto()
    {
        return $this->belongsTo(Foto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
