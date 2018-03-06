<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 18/3/6
 * Time: 上午11:32
 */

namespace Snower\LaravelForsun;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Facade extends LaravelFacade
{

    public static function getFacadeAccessor()
    {
        return 'forsun';
    }
}