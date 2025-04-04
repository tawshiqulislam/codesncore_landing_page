<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    use HasFactory;

    protected $table = 'product_requests';

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_note',
        'product_id',
        'product_name',
        'approved',
    ];
}
