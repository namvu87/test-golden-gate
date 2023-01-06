<?php

namespace App\Http\Resources\OrderProduct;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
        return [
            # [auto-gen-resource]
            'id' => $this->resource->id,
            'order_id' => $this->resource->order_id,
            'product_id' => $this->resource->product_id,
            'quantity' => $this->resource->quantity,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            # [/auto-gen-resource]
        ];
    }
}
