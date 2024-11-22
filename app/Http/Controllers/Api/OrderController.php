<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\Orders\OrderResource;
use App\Services\Orders\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    public function __construct(private readonly OrderService $orderService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $orders = $this->orderService->getOrderWithItems();

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrderRequest $request): OrderResource
    {
        $order = $this->orderService->store($request);

        return OrderResource::make($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): OrderResource
    {
        $order = $this->orderService->getOrderById($id);

        return OrderResource::make($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->orderService->destroy($id);
    }
}
