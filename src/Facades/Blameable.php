<?php

namespace AppKit\:package_name_php\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AppKit\:package_name_php\:package_name_php
 */
class :package_name_php extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ':package_name';
    }
}
