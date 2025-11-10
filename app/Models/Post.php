<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
            $model->updated_at = $model->freshTimestamp();
        });
        
        static::updating(function ($model) {
            $model->updated_at = $model->freshTimestamp();
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
