<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = ['nama', 'nip', 'jabatan', 'mata_pelajaran', 'pendidikan', 'foto', 'urutan', 'status'];
    
    protected $casts = [
        'status' => 'boolean',
    ];
}
