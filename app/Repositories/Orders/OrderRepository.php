<?php

namespace App\Repositories\Orders;

use App\Models\Order;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class OrderRepository extends BaseRepository
{
    /**
     * @var int
     */
    private int $customer_id;

    /**
     * @var float|null
     */
    private float|null $total = null;

    /** @var Order */
    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customer_id;
    }

    /**
     * @param int $customer_id
     */
    public function setCustomerId(int $customer_id): void
    {
        $this->customer_id = $customer_id;
    }

    /**
     * @return float|null
     */
    public function getTotal(): ?float
    {
        return $this->total;
    }

    /**
     * @param float|null $total
     */
    public function setTotal(?float $total): void
    {
        $this->total = $total;
    }

    /**
     * @return Builder|Model
     */
    public function store(): Model|Builder
    {
        return $this->order->newQuery()->create([
            'customer_id' => $this->getCustomerId(),
            'total' => $this->getTotal(),
        ]);
    }

    /**
     * @return int
     */
    public function update(): int
    {
        return $this->order->newQuery()->where('id', $this->getId())
            ->update([
                'customer_id' => $this->getCustomerId(),
                'total' => $this->getTotal(),
            ]);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getOrderWithItems(): LengthAwarePaginator
    {
        return $this->order->newQuery()
            ->with('items')
            ->paginate(request('per_page'));
    }

    /**
     * @param int $id
     * @return Model|Collection|Builder|array|null
     */
    public function getOrderById(int $id): Model|Collection|Builder|array|null
    {
        return $this->order->newQuery()->findOrFail($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id): mixed
    {
        return $this->order->newQuery()->where('id', $id)->delete();
    }
}
