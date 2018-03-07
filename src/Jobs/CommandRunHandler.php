<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 18/3/7
 * Time: 下午4:11
 */

namespace Snower\LaravelForsun\Jobs;

use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Mutex;
use Illuminate\Console\Scheduling\CacheMutex;

class CommandRunHandler implements ShouldQueue
{
    protected $mutex;

    public function __construct()
    {
        $container = Container::getInstance();

        $this->mutex = $container->bound(Mutex::class)
            ? $container->make(Mutex::class)
            : $container->make(CacheMutex::class);
    }

    public function handle($command){
        $event = new Event($this->mutex, $command);
        $event->run(Container::getInstance());
    }
}