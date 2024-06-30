<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category' => $this->category,
            'code' => $this->code,
            'name' => $this->name,
            'brand' => $this->brand,
            'buying_price' => $this->buying_price,
            'selling_price' => $this->selling_price,
            'stock' => $this->stock,
            'discount' => $this->discount,
            // 'details' => ProductDetailResource::collection($this->productDetails),
        ];
    }
}
