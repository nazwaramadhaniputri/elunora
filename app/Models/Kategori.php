<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama_kategori'];
    
    public $timestamps = false;
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
