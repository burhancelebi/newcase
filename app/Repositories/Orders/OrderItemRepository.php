<?php

namespace App\Repositories\Orders;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrderItemRepository
{
    /**
     * @var int
     */
    private int $order_id;

    /**
     * @var int
     */
    private int $product_id;

    /**
     * @var float
     */
    private float $unit_price;

    /**
     * @var float
     */
    private float $total;

    /**
     * @var int
     */
    private int $quantity;

    private OrderItem $orderItem;

    /**
     * @param OrderItem $orderItem
     */
    public function __construct(OrderItem $orderItem)
    {
        $this->orderItem = $orderItem;
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->order_id;
    }

    /**
     * @param int $order_id
     */
    public function setOrderId(int $order_id): void
    {
        $this->order_id = $order_id;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * @param int $product_id
     */
    public function setProductId(int $product_id): void
    {
        $this->product_id = $product_id;
    }

    /**
     * @return float
     */
    public function getUnitPrice(): float
    {
        return $this->unit_price;
    }

    /**
     * @param float $unit_price
     */
    public function setUnitPrice(float $unit_price): void
    {
        $this->unit_price = $unit_price;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @param float $total
     */
    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return Model|Builder
     */
    public function store(): Model|Builder
    {
        return $this->orderItem->newQuery()->create([
            'order_id' => $this->getOrderId(),
            'product_id' => $this->getProductId(),
            'unit_price' => $this->getUnitPrice(),
            'quantity' => $this->getQuantity(),
            'total' => $this->getTotal(),
        ]);
    }

    /**
     * @param int $order_id
     * @return mixed
     */
    public function destroyByOrderId(int $order_id): mixed
    {
        return $this->orderItem->newQuery()
            ->where('order_id', $order_id)
            ->delete();
    }
}
