<?php

namespace Haodanku\Black;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['black'] = function ($app) {
            return new BlackClient($app);
        };
    }
}