<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'customer_id' => $this->resource->customer_id,
            'employee_id' => $this->resource->employee_id,
            'code' => $this->resource->code,
            'status' => $this->resource->status,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            # [/auto-gen-resource]
        ];
    }
}
