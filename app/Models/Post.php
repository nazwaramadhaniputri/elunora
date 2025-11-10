<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $fillable = ['judul', 'isi', 'kategori_id', 'petugas_id', 'status', 'gambar', 'created_at', 'updated_at'];
    
    protected $casts = [
        'kategori_id' => 'integer',
        'petugas_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    // Aktifkan timestamps
    public $timestamps = true;
    
    // Override method untuk memastikan timestamps selalu diisi
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($model) {
            // Pastikan selalu ada petugas_id
            if (empty($model->petugas_id)) {
                $model->petugas_id = Auth::guard('petugas')->id() ?? 1;
            }
            
            // Pastikan selalu ada timestamp
            $now = now();
            if (empty($model->created_at)) {
                $model->created_at = $now;
            }
            $model->updated_at = $now;
        });
    }
    
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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
