<?php

namespace App\Http\Resources\OrderInvoice;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderInvoiceResource extends JsonResource
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
            'customer_id' => $this->resource->customer_id,
            'status' => $this->resource->status,
            'sub_total' => $this->resource->sub_total,
            'total_received' => $this->resource->total_received,
            'total_returned' => $this->resource->total_returned,
            'type' => $this->resource->type,
            'employee_id' => $this->resource->employee_id,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            # [/auto-gen-resource]
        ];
    }
}
