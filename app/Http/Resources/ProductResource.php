<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'categoryName' => $this->category->name,
            'producerName' => $this->producer->name,
            'name' => $this->name,
            'import_price' => $this->import_price,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'image' => $this->image,
            'describe' => $this->describe,        
        ];
    }
}
