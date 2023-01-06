<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;


class EmployeeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return ($this->resource instanceof LengthAwarePaginator) ?
            [
                'data' => EmployeeResource::collection($this->collection),
                'pagination' => [
                    'size' => $this->perPage(),
                    'total' => $this->total(),
                    'current' => $this->currentPage(),
                    'last' => $this->lastPage(),
                    'base' => $this->url(1),
                    'next' => $this->nextPageUrl(),
                    'prev' => $this->previousPageUrl()
                ]
            ] : EmployeeResource::collection($this->collection);
    }
}
