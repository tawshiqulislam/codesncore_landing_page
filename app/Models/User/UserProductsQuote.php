<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProductsQuote extends Model
{
    use HasFactory;

    protected $table = 'user_products_quote';

    protected $fillable = [
        'image',
        'other_images',
        'name',
        'slug',
        'content',
        'serial_number',
        'featured',
        'detail_page',
        'lang_id',
        'user_id',
        'meta_keywords',
        'meta_description',
        'icon',
    ];

    public function language() {
        return $this->belongsTo(Language::class,'lang_id');
    }
}
