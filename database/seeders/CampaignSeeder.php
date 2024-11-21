<?php

namespace Database\Seeders;

use App\Models\Campaign;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Campaign::query()->truncate();

        $sqls = [
            'rule_1' => [
                'key' => '10_PERCENT_OVER_1000',
                'check_campaign_sql' => 'SELECT * FROM orders WHERE id = ? AND total >= 1000;',
                'make_discount_sql' => 'UPDATE orders SET total = total - total / 10 WHERE id = ?;',
            ],
            'rule_2' => [
                'key' => 'BUY_5_GET_1',
                'check_campaign_sql' => 'select o.id, o.total, o.customer_id, oi.id,
       p.category, (@position := ifnull(@position, 0) + 1)
from orders o
         left join order_items oi on o.id = oi.order_id
         left join products p on p.id = oi.product_id
where p.category = 2 and o.id = ?
group by oi.id, o.id having @position >= 6 limit 1;',
                'make_discount_sql' => 'UPDATE orders o LEFT JOIN order_items oi on o.id = oi.order_id SET o.total = o.total - oi.total
WHERE o.id = ?;',
            ],
            'rule_3' => [
                'key' => 'DISCOUNT_BY_20_PERCENT',
                'check_campaign_sql' => 'select o.id, oi.total, o.customer_id, oi.id,
       p.category,
       (@position := ifnull(@position, 0) + 1),
       CONCAT(oi.total * 20 / 100) as discounted_total
from orders o
         left join order_items oi on o.id = oi.order_id
         left join products p on p.id = oi.product_id
where p.category = 1 and o.id = ?
group by oi.id, o.id, oi.total having @position >= 2 order by oi.total asc limit 1;',
                'make_discount_sql' => 'UPDATE orders o,
    (
        SELECT (@total := ifnull(@total, 0) + oi.total * 20 / 100) as discounted_product
        FROM order_items oi
        left join products p on oi.product_id = p.id
        where oi.order_id = 1 and p.id = 1
        order by oi.total asc limit 1
    ) as item
SET o.total = o.total - item.discounted_product
WHERE o.id = ? ;',
            ],
        ];

        foreach ($sqls as $sql)
        {
            Campaign::query()->create($sql);
        }
    }
}
