<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_customer',
        'id_ward',
        'name',
        'phone',
    ];


    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

