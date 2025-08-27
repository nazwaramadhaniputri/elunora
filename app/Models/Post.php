<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['judul', 'isi', 'kategori_id', 'petugas_id', 'status', 'gambar'];
    
    public $timestamps = false;
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    
    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
    
    public function galeris()
    {
        return $this->hasMany(Galeri::class);
    }
}
