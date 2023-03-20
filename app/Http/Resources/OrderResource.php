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
            'payments' => $this->payments,
            'total' => $this->total,
            'status' => $this->status,
            'order_date' => $this->order_date,
        
            'name' => $this->contact->name,
            'phone' => $this->contact->phone,
            'address' => $this->contact->address,

            'ward' => $this->contact->ward->name,
            'district' => $this->contact->ward->district->name,
            'city' => $this->contact->ward->district->city->name,

            'order_details' => $this->orderDetails->map(function ($orderDetail) {
                return [
                    'quantity' => $orderDetail->quantity,
                    'price' => $orderDetail->price,
                    'import_price' => $orderDetail->product->import_price,
                    'productName' => $orderDetail->product->name,
                    'productImage' => $orderDetail->product->image,
                    
                ];
            }),
            
            'employee' => $this->employee,
          

        ];
    }
}
