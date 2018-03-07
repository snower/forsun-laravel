<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 18/3/7
 * Time: 下午4:11
 */

namespace Snower\LaravelForsun\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Container\Container;

class EventFireHandler implements ShouldQueue
{
    public function handle($event, $payload = [], $halt = false){
        Container::getInstance()->make('events')->fire($event, $payload, $halt);
    }
}