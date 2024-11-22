<?php

namespace App\Repositories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CampaignRepository extends BaseRepository
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $key;

    /**
     * @var string
     */
    private string $make_discount_sql;

    /**
     * @var string
     */
    private string $check_campaign_sql;

    public function __construct(private readonly Campaign $campaign)
    {
    }

    /**
     * @return string
     */
    public function getMakeDiscountSql(): string
    {
        return $this->make_discount_sql;
    }

    /**
     * @param string $make_discount_sql
     */
    public function setMakeDiscountSql(string $make_discount_sql): void
    {
        $this->make_discount_sql = $make_discount_sql;
    }

    /**
     * @return string
     */
    public function getCheckCampaignSql(): string
    {
        return $this->check_campaign_sql;
    }

    /**
     * @param string $check_campaign_sql
     */
    public function setCheckCampaignSql(string $check_campaign_sql): void
    {
        $this->check_campaign_sql = $check_campaign_sql;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * @return Model|Builder
     */
    public function store(): Model|Builder
    {
        return $this->campaign->newQuery()
            ->create([
                'key' => $this->getKey(),
                'make_discount_sql' => $this->getMakeDiscountSql(),
                'check_campaign_sql' => $this->getCheckCampaignSql(),
            ]);
    }

    /**
     * @return Collection|array
     */
    public function getCampaigns(): Collection|array
    {
        return $this->campaign->newQuery()->get();
    }
}
