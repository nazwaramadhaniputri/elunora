<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'nama',
        'email', 
        'subjek',
        'pesan',
        'status'
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function getStatusTextAttribute()
    {
        return $this->status == 1 ? 'Dibaca' : 'Belum Dibaca';
    }
}
