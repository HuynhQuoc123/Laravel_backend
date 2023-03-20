<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_customer',
        'id_employee',
        'id_contact',
        'order_date',
        'payments',
        'total',
        'status',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'id_contact');    
    }
    public function employee()
    {
        return $this->belongsTo(User::class, 'id_employee');    
    }

}
