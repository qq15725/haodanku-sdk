<?php

namespace Haodanku\Auth;

use SDK\Kernel\AccessToken as BaseAccessToken;

class AccessToken extends BaseAccessToken
{
    protected function appendQuery(): array
    {
        return [
            'apikey' => $this->app->config->get('apikey'),
        ];
    }
}