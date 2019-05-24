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
    public $event;
    public $payload;
    public $halt;

    public function __construct($event, $payload = [], $halt = false)
    {
        $this->event = $event;
        $this->payload = $payload;
        $this->halt = $halt;
    }

    public function handle(){
        Container::getInstance()->make('events')->dispatch($this->event, $this->payload, $this->halt);
    }
}