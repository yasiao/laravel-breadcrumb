<?php

namespace Yasiao\Breadcrumb;

use Illuminate\Support\Facades\Facade;

class BreadcrumbFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return Breadcrumb::class;
    }
}