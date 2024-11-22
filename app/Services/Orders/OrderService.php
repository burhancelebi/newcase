<?php

namespace App\Services\Orders;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\Orders\OrderResource;
use App\Models\Order;
use App\Repositories\Orders\OrderRepository;
use App\Services\BaseService;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderService extends BaseService
{
    /** @var OrderRepository  */
    private OrderRepository $orderRepository;

    /** @var OrderItemService  */
    private OrderItemService $itemService;

    public function __construct(OrderRepository $orderRepository,
                                OrderItemService $itemService)
    {
        $this->orderRepository = $orderRepository;
        $this->itemService = $itemService;
    }

    /**
     * @param CreateOrderRequest $request
     * @return OrderResource|JsonResponse
     */
    public function store(CreateOrderRequest $request): JsonResponse|OrderResource
    {
        try {
            DB::beginTransaction();
            $this->orderRepository->setCustomerId($request->get('customer_id'));

            /** @var Order|Model|Builder $order */
            $order = $this->orderRepository->store();
            $this->itemService->store($request, $order);
            DB::commit();

            return OrderResource::make($order);
        } catch (Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], $exception->getCode());
        }
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getOrderWithItems(): LengthAwarePaginator
    {
        return $this->orderRepository->getOrderWithItems();
    }

    /**
     * @param int $id
     * @return array|Collection|Model|null
     */
    public function getOrderById(int $id): array|Collection|Model|null
    {
        return $this->orderRepository->getOrderById($id);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->itemService->destroyByOrderId($id);
            $order = $this->orderRepository->getOrderById($id);
            $order->delete();
            DB::commit();

            return response()->json([
                'message' => 'Order Deleted'
            ]);

        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ]);
        }
    }
}
