<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {

        return [
            'id'=>$this->id,
            'tensp'=>$this->name,
            'gia'=>$this->price,
            'ngaytao'=>$this->created_at->format('d/m/Y'),
            'ngaycapnhat'=>$this->updated_at->format('d/m/Y'),
        ];
    }
}
