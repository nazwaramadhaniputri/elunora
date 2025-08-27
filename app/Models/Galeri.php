<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $fillable = ['post_id', 'judul', 'deskripsi', 'position', 'status'];
    
    public function getStatusTextAttribute()
    {
        return $this->status == 1 ? 'Aktif' : 'Tidak Aktif';
    }
    
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    
    public function fotos()
    {
        return $this->hasMany(Foto::class, 'galery_id');
    }
}
