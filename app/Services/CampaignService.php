<?php

namespace App\Services;

use App\Http\Requests\CampaignRequest;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use App\Models\Order;
use App\Repositories\CampaignRepository;
use App\Services\Orders\OrderService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class CampaignService extends BaseService
{
    public function __construct(private readonly CampaignRepository $repository,
    private readonly OrderService $orderService)
    {
    }

    /**
     * @param CampaignRequest $request
     * @return Builder|Campaign|Model
     */
    public function store(CampaignRequest $request): Builder|Campaign|Model
    {
        $this->repository->setKey($request->get('key'));
        $this->repository->setMakeDiscountSql($request->get('make_discount_sql'));
        $this->repository->setCheckCampaignSql($request->get('check_campaign_sql'));

        return $this->repository->store();
    }

    /**
     * @return array|Collection
     */
    public function getCampaigns(): array|Collection
    {
        return $this->repository->getCampaigns();
    }

    /**
     * @param int $order_id
     * @return array
     */
    public function applyCampaign(int $order_id): array
    {
        $response = [];
        $total_discount = 0;

        $campaigns = $this->getCampaigns();

        /** @var Campaign $campaign */
        foreach ($campaigns as $campaign)
        {
            $result = DB::select($campaign->check_campaign_sql, [$order_id])[0] ?? null;

            if (!is_null($result))
            {
                DB::statement($campaign->make_discount_sql, [$order_id]);

                /** @var Order $order */
                $order = $this->orderService->getOrderById($order_id);
                $discount_amount = $result->total - $order->total;
                $total_discount += $discount_amount;

                if (isset($result->discounted_total))
                    $discount_amount = $result->discounted_total;

                $response['orderId'] = $order_id;
                $response['discounts'][] = [
                    'discountReason' => $campaign->key,
                    'discountAmount' => number_format($discount_amount, 2),
                    'subtotal' => $order->total,
                ];
            }
        }

        $response['totalDiscount'] = number_format($total_discount, 2);
        $response['discountedTotal'] = isset($order) ? $order->total : 0;

        return $response;
    }
}
