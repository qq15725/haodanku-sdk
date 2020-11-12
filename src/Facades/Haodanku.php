<?php

namespace Haodanku\Facades;

use Illuminate\Support\Facades\Facade;
use Haodanku\Application;

/**
 * @mixin Application
 */
class Haodanku extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Application::class;
    }

    /**
     * @return Application
     */
    public static function getFacadeRoot()
    {
        return parent::getFacadeRoot();
    }
}
