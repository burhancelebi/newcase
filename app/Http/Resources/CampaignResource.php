<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $key
 * @property string $make_discount_sql
 * @property string $check_campaign_sql
 */
class CampaignResource extends JsonResource
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
            'key' => $this->key,
            'check_campaign_sql' => $this->check_campaign_sql,
            'make_discount_sql' => $this->make_discount_sql,
        ];
    }
}
