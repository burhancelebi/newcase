<?php

namespace App\Services\Orders;

use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Repositories\Orders\OrderItemRepository;
use App\Repositories\Orders\OrderRepository;
use App\Services\BaseService;
use App\Services\ProductService;

class OrderItemService extends BaseService
{
    public function __construct(private readonly OrderItemRepository $itemRepository,
    private readonly ProductService $productService,
    private readonly OrderRepository $orderRepository)
    {
    }

    /**
     * @param CreateOrderRequest $request
     * @param Order $order
     * @return void
     */
    public function store(CreateOrderRequest $request, Order $order): void
    {
        $orderTotal = 0;

        foreach ($request->get('products') as $item)
        {
            $product = $this->productService->getProductById($item['id']);
            $total = $product->price * $item['quantity'];
            $this->itemRepository->setOrderId($order->id);
            $this->itemRepository->setTotal($total);
            $this->itemRepository->setProductId($item['id']);
            $this->itemRepository->setQuantity($item['quantity']);
            $this->itemRepository->setUnitPrice($product->price);
            $orderTotal += $total;
            $this->itemRepository->store();
        }

        $this->orderRepository->setId($order->id);
        $this->orderRepository->setTotal($orderTotal);
        $this->orderRepository->setCustomerId($order->customer_id);
        $this->orderRepository->update();
    }

    /**
     * @param int $order_id
     * @return mixed
     */
    public function destroyByOrderId(int $order_id): mixed
    {
        return $this->itemRepository->destroyByOrderId($order_id);
    }
}
