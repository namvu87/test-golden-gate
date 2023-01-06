<?php

namespace App\Http\Resources;

use App\Models\Employee;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request) {
        return [
            # [auto-gen-resource]
            'id' => $this->resource->id,
            'fullname' => $this->resource->fullname,
            'birthday' => $this->resource->birthday,
            'gender' => Employee::GENDER[$this->resource->gender],
            'marital_status' => Employee::MARITAL_STATUS[$this->resource->marital_status],
            'local_address' => $this->resource->local_address,
            'province_id' => $this->resource->province_id,
            'card_number' => $this->resource->card_number,
            'date_card' => $this->resource->date_card,
            'address_card' => $this->resource->address_card,
            'phone' => $this->resource->phone,
            'zalo' => $this->resource->zalo,
            'facebook' => $this->resource->facebook,
            'level' => Employee::LEVEL[$this->resource->level],
            'address_permanent' => $this->resource->address_permanent,
            'email' => $this->resource->email,
            'school' => $this->resource->school,
            'created_by' => $this->resource->created_by,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            # [/auto-gen-resource]
        ];
    }
}
