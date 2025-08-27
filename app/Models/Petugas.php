<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Authenticatable
{
    protected $fillable = ['username', 'password', 'email'];
    
    public $timestamps = false;
    
    protected $hidden = [
        'password',
    ];
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
