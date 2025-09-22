<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoComment extends Model
{
    use HasFactory;

    protected $table = 'foto_comments';

    protected $fillable = [
        'foto_id',
        'content',
        'guest_name',
        'guest_ip',
    ];

    public function foto()
    {
        return $this->belongsTo(Foto::class);
    }
}
