<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_category',
        'id_producer',
        'name',
        'import_price',
        'price',
        'quantity',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'id_category');
    }
    public function producer()
    {
        return $this->belongsTo('App\Models\Producer', 'id_producer');
    }

    public function cart() {
        return $this->belongsToMany(Carts::class, 'carts')->withPivot(['id', 'quantity']);
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'product_id', 'id');
    }
}
