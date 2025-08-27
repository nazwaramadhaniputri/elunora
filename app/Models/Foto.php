<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $fillable = ['galery_id', 'file', 'judul'];
    
    public $timestamps = false;
    
    public function galeri()
    {
        return $this->belongsTo(Galeri::class, 'galery_id');
    }
}
