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

class CommandRunHandler implements ShouldQueue
{
    public $command;

    public function __construct($command)
    {
        $this->command = $command;
    }

    public function handle(){
        $laravel = Container::getInstance();

        if(class_exists('Illuminate\Console\Scheduling\CacheMutex')){
            $cachemutex_class = 'Illuminate\Console\Scheduling\CacheMutex';
        } else {
            $cachemutex_class = 'Illuminate\Console\Scheduling\CacheEventMutex';
        }

        $mutex = $laravel->bound(Mutex::class)
            ? $laravel->make(Mutex::class)
            : $laravel->make($cachemutex_class);

        $event = new Event($mutex, $this->command);
        $event->run($laravel);
    }
}