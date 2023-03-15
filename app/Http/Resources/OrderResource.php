<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'id_customer' => $this->id_customer,
            'id_employee' => $this->id_employee,
            'id_contact' => $this->id_contact,
            'payments' => $this->payments,
            'total' => $this->total,
            'status' => $this->status,
            'order_date' => $this->order_date,
            'order_details' => $this->orderDetails->map(function ($orderDetail) {
                return [
                    'quantity' => $orderDetail->quantity,
                    'price' => $orderDetail->price,
                    'productName' => $orderDetail->product->name,
                    'productImage' => $orderDetail->product->image,
                    
                ];
            }),
        ];
    }
}
