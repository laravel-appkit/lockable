<?php

namespace AppKit\Lockable;

class Lockable
{
    private $app;

    public function __construct()
    {
        $this->app = app();
    }

    // Build your next great package.
}
