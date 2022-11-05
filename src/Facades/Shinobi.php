<?php

namespace JalalLinuX\Shinobi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JalalLinuX\Shinobi\Shinobi
 */
class Shinobi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \JalalLinuX\Shinobi\Shinobi::class;
    }
}
