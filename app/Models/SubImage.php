<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubImage extends Model
{
    use HasFactory;
    protected $table = 'images';

    protected $fillable = [
        'product_id',
        'image',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
