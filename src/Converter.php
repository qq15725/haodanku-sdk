<?php

namespace Haodanku;

use SDK\Kernel\Support\Collection;

class Converter
{
    /**
     * 商品数据转换成统一的数据格式
     *
     * @param array $raw
     * @param null $apiType
     * @param bool $retainRaw
     *
     * @return array
     */
    public static function product(array $raw, $apiType = null, $retainRaw = true): array
    {
        if (!$raw) {
            return [];
        }

        if (isset($raw[0])) {
            foreach ($raw as &$itemRaw) {
                $itemRaw = self::product($itemRaw, $apiType, $retainRaw);
            }
            return $raw;
        }

        $data = new Collection($raw);

        $couponUrl = $data->get('couponurl');
        $matchs = [];
        preg_match('#activityId=(\w+)#', $couponUrl, $matchs);
        $couponId = $matchs[1] ?? null;
        preg_match('#sellerId=(\w+)#', $couponUrl, $matchs);
        $shopId = $matchs[1] ?? null;
        $productId = $data->get('itemid');

        $data = [
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
            'coupons' => [
                [
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
                ]
            ],
            'shop' => [
                'id' => $shopId,
                'logo' => null,
                'name' => $data->get('shopname'),
                'type' => $data->get('shoptype') == 'B' ? 'tmall' : 'taobao',
            ]
        ];

        if ($retainRaw) {
            $data['raw'] = $raw;
        }

        return $data;
    }
}