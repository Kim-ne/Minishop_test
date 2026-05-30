<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'email' => $this->email,
            'payment_method' => $this->payment_method,
            'total_amount' => $this->total_amount,
            'total_formatted' => number_format($this->total_amount, 0, ',', '.') . 'USD',
            'notes' => $this->notes,
            'order_date' => $this->order_date,
            'status' => $this->status,
            'status_label' => $this->status_label,

            // Customer info - just load when eager loaded
            'customer' => $this->whenLoaded('customer', fn() => [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
                'email' => $this->customer->email
            ]),

            // items
            'items' => $this->whenLoaded('items', function () {
                return $this->items->map(fn($item) => [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product?->name,
                    'qty'=> $item->qty,
                    'price' => $item->price,
                    'price_formatted' => number_format($item->price, 0, ',', '.') . 'USD',
                    'subtotal' => $item->qty * $item->price,
                    'subtotal_formatted' => number_format($item->subtotal, 0, ',', '.') . 'USD',

                ]);
            }),

            'created_at' => $this->created_at?->format('d/m/Y H:i'),
            'updated_at' => $this->updated_at?->format('d/m/Y H:i'),

        ];
    }
}
