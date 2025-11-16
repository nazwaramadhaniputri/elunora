<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPhoto extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image_path',
        'status',
        'admin_notes'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function isPending()
    {
        return $this->status === 'pending';
    }
    
    public function isApproved()
    {
        return $this->status === 'approved';
    }
    
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
    
    public function getImageUrlAttribute()
    {
        // If no image path, return default image
        if (empty($this->image_path)) {
            return asset('images/default-photo.jpg');
        }

        // If it's already a full URL, return as is
        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return $this->image_path;
        }

        // Check in the correct uploads directory first
        $uploadPath = 'uploads/galeri/user/' . basename($this->image_path);
        if (file_exists(public_path($uploadPath))) {
            return asset($uploadPath);
        }

        // If not found, try the original path
        if (file_exists(public_path($this->image_path))) {
            return asset($this->image_path);
        }

        // Try storage path as fallback
        if (file_exists(storage_path('app/public/' . $this->image_path))) {
            return asset('storage/' . $this->image_path);
        }

        // If nothing found, return default image
        return asset('images/default-photo.jpg');
    }
}
