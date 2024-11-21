<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = ['id', 'customer_id', 'total'];

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}