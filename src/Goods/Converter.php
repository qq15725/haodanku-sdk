<?php

namespace Haodanku\Goods;

use SDK\Kernel\Support\Collection;

class Converter
{
    public static function convert(array $raw): array
    {
        $data = new Collection($raw);

        $couponUrl = $data->get('couponurl');
        $matchs = [];
        preg_match('#activityId=(\w+)#', $couponUrl, $matchs);
        $couponId = $matchs[1] ?? null;
        preg_match('#sellerId=(\w+)#', $couponUrl, $matchs);
        $shopId = $matchs[1] ?? null;
        $productId = $data->get('itemid');

        return [
            'channel' => 'haodanku',
            'product' => [
                'id' => $productId,
                'shop_id' => $shopId,
                'category_id' => null,
                'title' => $data->get('itemtitle'),
                'short_title' => $data->get('itemshorttitle'),
                'desc' => $data->get('itemdesc'),
                'cover' => $data->get('itempic'),
                'banners' => $data->has('taobao_image')
                    ? explode(',', $data->get('taobao_image'))
                    : null,
                'sales_count' => (int)$data->get('itemsale'),
                'rich_text_images' => [],
                'url' => "https://detail.tmall.com/item.htm?id={$productId}",
            ],
            'coupon_product' => [
                'price' => (float)$data->get('itemendprice'),
                'original_price' => (float)$data->get('itemprice'),
                'commission_rate' => (float)$data->get('tkrates'),
                'commission_amount' => (float)bcmul(
                    (float)$data->get('itemendprice'),
                    bcdiv(
                        (float)$data->get('tkrates'),
                        100,
                        2
                    ),
                    2
                ),
            ],
            'coupon' => [
                'id' => $couponId,
                'shop_id' => $shopId,
                'product_id' => $productId,
                'amount' => (float)$data->get('couponmoney'),
                'rule_text' => $data->get('couponexplain'),
                'stock' => (int)$data->get('couponsurplus'),
                'total' => (int)$data->get('couponnum'),
                'started_at' => date('Y-m-d H:i:s', (int)$data->get('couponstarttime')),
                'ended_at' => date('Y-m-d H:i:s', (int)$data->get('couponendtime')),
                'url' => $couponUrl,
                'raw' => $raw,
            ],
            'shop' => [
                'id' => $shopId,
                'logo' => null,
                'name' => $data->get('shopname'),
                'type' => $data->get('shoptype') == 'B' ? 'tmall' : 'taobao',
            ]
        ];
    }
}