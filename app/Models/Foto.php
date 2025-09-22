<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $fillable = ['galery_id', 'file', 'judul', 'likes_count'];
    
    public $timestamps = false;
    
    public function galeri()
    {
        return $this->belongsTo(Galeri::class, 'galery_id');
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\FotoComment::class, 'foto_id');
    }
}
