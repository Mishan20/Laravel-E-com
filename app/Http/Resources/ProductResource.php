<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'p_id' => $this->p_id,
            'name' => $this->name,
            'qty' => $this->qty,
            'price' => number_format($this->price, 2),
            'status' => $this->status,
            'category_id' => $this->category->name,
            'seller_id' => $this->seller->name,
            'image' => $this->image,
            'created_at' => $this->created_at->format('Y-M-d H:i:s')
        ];
    }
}
