<?php

namespace AppKit\Lockable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AppKit\Lockable\Lockable
 */
class Lockable extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lockable';
    }
}
