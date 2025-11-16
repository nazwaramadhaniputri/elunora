<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ActivityLog extends Model
{
    protected $fillable = [
        'petugas_id',
        'action',
        'description',
        'model_type',
        'model_id',
        'old_data',
        'new_data',
        'ip_address',
        'user_agent',
        'url',
        'method'
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];

    public function petugas()
    {
        return $this->belongsTo(\App\Models\Petugas::class);
    }

    public function model()
    {
        return $this->morphTo();
    }
}
