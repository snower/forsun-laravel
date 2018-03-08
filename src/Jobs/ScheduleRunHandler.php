<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 18/3/7
 * Time: 下午5:58
 */

namespace Snower\LaravelForsun\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Container\Container;

class ScheduleRunHandler implements ShouldQueue
{
    public function handle(){
        $laravel = Container::getInstance();
        $schedule = $laravel->make(Schedule::class);

        foreach ($schedule->dueEvents($laravel) as $event) {
            if (! $event->filtersPass($laravel)) {
                continue;
            }

            $event->run($laravel);
        }
    }
}