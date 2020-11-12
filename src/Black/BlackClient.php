<?php

namespace Haodanku\Black;

use SDK\Kernel\BaseClient;

class BlackClient extends BaseClient
{
    /**
     * @link https://www.haodanku.com/api/detail/show/7.html
     *
     * @return array
     */
    public function list()
    {
        return $this->httpGet('blacklist');
    }
}