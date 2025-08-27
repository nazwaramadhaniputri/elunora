<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['nama_sekolah', 'alamat', 'telepon', 'email', 'deskripsi', 'foto'];
    
    public $timestamps = false;
}
