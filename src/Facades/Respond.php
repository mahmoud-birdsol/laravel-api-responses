<?php

namespace Alacrity\Responses\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Respond
 *
 * @package Alacrity\Responses\Facades
 * @see Alacrity\Responses\Respond
 */
class Respond extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'respond'; }
}