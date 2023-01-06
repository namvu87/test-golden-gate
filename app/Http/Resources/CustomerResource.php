<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'customer_abbreviations' => $this->resource->customer_abbreviations,
            'contact_name' => $this->resource->contact_name,
            'address_office' => $this->resource->address_office,
            'contact_phone' => $this->resource->contact_phone,
            'website' => $this->resource->website,
            'email' => $this->resource->email,
            'representative' => $this->resource->representative,
            'position' => $this->resource->position,
            'address_business' => $this->resource->address_business,
            'tax_code' => $this->resource->tax_code,
            'field_id' => $this->resource->field_id,
            'type' => $this->resource->type,
            'employee_id' => $this->resource->employee_id,
            'status' => $this->resource->status,
            'note' => $this->resource->note,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            # [/auto-gen-resource]
        ];
    }
}
