<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampaignRequest;
use App\Http\Resources\CampaignResource;
use App\Services\CampaignService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CampaignController extends Controller
{
    public function __construct(private readonly CampaignService $campaignService)
    {
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $campaigns = $this->campaignService->getCampaigns();

        return CampaignResource::collection($campaigns);
    }

    /**
     * @param int $order_id
     * @return array
     */
    public function applyCampaign(int $order_id): array
    {
        return $this->campaignService->applyCampaign($order_id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CampaignRequest $request): CampaignResource
    {
        $campaign = $this->campaignService->store($request);

        return CampaignResource::make($campaign);
    }
}
