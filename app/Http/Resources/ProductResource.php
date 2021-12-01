<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
        $image = null;

        if (!empty($this->image) && Storage::exists('public/product/' . $this->image)) {
            $image = 'storage/product/' . $this->image;
        }

        return [
            'id' => $this->id,
            'category' => [
                'id' => $this->category_id,
                'name' => $this->category->name,
            ],
            'name' => $this->name,
            'price' => $this->price,
            'sku' => $this->sku,
            'status' => $this->status,
            'image' => $image,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
