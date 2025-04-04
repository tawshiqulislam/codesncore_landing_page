<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGallery extends Model
{
    use HasFactory;

    protected $table = 'user_galleries';

    protected $guarded = [];

    // Relationship to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}