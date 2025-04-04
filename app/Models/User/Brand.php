<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = "user_brands";
    
    protected $casts = [
        'distributor' => 'boolean'
    ];

    protected $fillable = [
        'user_id',
        'language_id',
        'brand_img',
        'brand_url',
        'serial_number',
        'distributor'
    ];

    public function brandLang()
    {
        return $this->belongsTo(Language::class);
    }
}
