<?php

namespace Haodanku;

use SDK\Kernel\ServiceContainer;

/**
 * Class Application.
 *
 * @link https://www.haodanku.com/api/detail
 *
 * @property \Haodanku\Goods\GoodsClient $goods 商品
 * @property \Haodanku\Black\BlackClient $black 黑名单
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Auth\ServiceProvider::class,
        Goods\ServiceProvider::class,
        Black\ServiceProvider::class,
    ];

    /**
     * @var array
     */
    protected $defaultConfig = [
        'http' => [
            'timeout' => 10.0,
            'base_uri' => 'http://v2.api.haodanku.com'
        ],
    ];

    public function __construct(
        string $apikey = null,
        array $config = [],
        array $prepends = []
    )
    {
        $config = array_merge([
            'apikey' => $apikey,
        ], $config);
        parent::__construct($config, $prepends);
    }
}