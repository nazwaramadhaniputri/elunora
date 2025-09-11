<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Petugas extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'petugas';
    
    protected $fillable = [
        'username', 
        'password', 
        'email',
        'nama_lengkap',
        'level'
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
