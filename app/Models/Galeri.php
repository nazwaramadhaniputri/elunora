<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Galeri extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'category_id',
        'judul',
        'deskripsi',
        'position',
        'status'
    ];
    
    protected $with = ['category'];

    protected $casts = [
        'post_id' => 'integer',
        'position' => 'integer',
        'status' => 'boolean'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function fotos()
    {
        return $this->hasMany(Foto::class, 'galeri_id');
    }
    
    public function getStatusTextAttribute()
    {
        return $this->status ? 'Aktif' : 'Tidak Aktif';
    }
    
    public function category()
    {
        return $this->belongsTo(GalleryCategory::class, 'category_id');
    }
}
