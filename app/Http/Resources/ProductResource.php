<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array JSON response.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'price_formatted' => number_format($this->price, 0, ',', '.') . 'USD',
            'stock' => $this->stock,
            'status' => $this->status,
            'is_featured' => $this->is_featured,
            'image' => $this->image ? asset('storage/' . $this->image) : null,

            // Relations - just load when eager loaded

            'category'=> $this->whenLoaded('category',fn() => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ]),

            'created_at' => $this->created_at?->format('Y-m-d H:i'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i'),
        ];
    }
}
