<?php

namespace App\Http\Resources\Orders;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property int $customer_id
 * @property HasMany|OrderItem $items
 * @property float $total
 */
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
            'customer_id' => $this->customer_id,
            'items' => OrderItemResource::collection($this->items),
            'total' => $this->total
        ];
    }
}
