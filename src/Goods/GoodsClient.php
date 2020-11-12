<?php

namespace Haodanku\Goods;

use SDK\Kernel\BaseClient;

class GoodsClient extends BaseClient
{
    /**
     * @param int $minId
     * @param int $perPage
     * @param array $query
     *
     * @link https://www.haodanku.com/api/detail/show/1.html
     *
     * @return array
     */
    public function list(int $minId = 1, int $perPage = 100, array $query = [])
    {
        $query += [
            'min_id' => $minId,
            'back' => $perPage,
        ];

        return $this->httpGet('itemlist', $query);
    }

    /**
     * @param $id
     *
     * @link https://www.haodanku.com/api/detail/show/16.html
     *
     * @return array
     */
    public function find($id)
    {
        return $this->httpGet('item_detail', [
            'itemid' => $id,
        ]);
    }

    /**
     * 新增商品列表
     *
     * @param int $minId 分页，用于实现类似分页抓取效果，来源于上次获取后的数据的min_id值，默认开始请求值为1（该方案比单纯123分页的优势在于：数据更新的情况下保证不会重复也无需关注和计算页数）
     * @param int $perPage 每页返回条数（请在1,2,10,20,50,100,120,200,500,1000中选择一个数值返回）
     * @param int $start 小时点数，如0点是0、13点是13（最小值是0，最大值是23）
     * @param int $end 小时点数，如0点是0、13点是13（最小值是0，最大值是23）
     * @param int|null $itemType 是否只获取营销返利商品，1是，0否
     * @param array $query
     *
     * @link https://www.haodanku.com/Openapi/api_detail?id=7
     *
     * @return array
     */
    public function createdList(
        int $minId = 1,
        int $perPage = 100,
        int $start = 0,
        int $end = 23,
        int $itemType = null,
        array $query = []
    )
    {
        $query += [
            'start' => $start,
            'end' => $end,
            'min_id' => $minId,
            'back' => $perPage,
            'item_type' => $itemType,
        ];

        return $this->httpGet('timing_items', $query);
    }

    /**
     * 更新商品列表
     *
     * @param int $minId 分页，用于实现类似分页抓取效果，来源于上次获取后的数据的min_id值，默认开始请求值为1（该方案比单纯123分页的优势在于：数据更新的情况下保证不会重复也无需关注和计算页数）
     * @param int $perPage 每页返回条数（请在1,2,10,20,50,100,120,200,500,1000中选择一个数值返回）
     * @param int $sort 更新排序（1好单指数，2月销量，3近两小时销量，4当天销量，5在线人数，6活动开始时间）
     * @param array $query
     *
     * @link https://www.haodanku.com/Openapi/api_detail?id=14
     *
     * @return array
     */
    public function updatedList(
        int $minId = 1,
        int $perPage = 100,
        int $sort = 1,
        array $query = []
    )
    {
        $query += [
            'min_id' => $minId,
            'back' => $perPage,
            'sort' => $sort,
        ];

        return $this->httpGet('update_item', $query);
    }

    /**
     * 删除商品列表
     *
     * @param int $start 小时点数，如0点是0、13点是13（最小值是0，最大值是23）
     * @param int $end 小时点数，如0点是0、13点是13（最小值是0，最大值是23）
     * @param array $query
     *
     * @link https://www.haodanku.com/Openapi/api_detail?id=8
     *
     * @return array
     */
    public function deletedList(
        int $start = 0,
        int $end = 23,
        array $query = []
    )
    {
        $query += [
            'start' => $start,
            'end' => $end,
        ];

        return $this->httpGet('get_down_items', $query);
    }
}