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
    protected $schedule;

    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    public function handle(){
        $eventsRan = false;
        $laravel = Container::getInstance();

        foreach ($this->schedule->dueEvents($laravel) as $event) {
            if (! $event->filtersPass($laravel)) {
                continue;
            }

            $this->line('<info>Running scheduled command:</info> '.$event->getSummaryForDisplay());

            $event->run($laravel);

            $eventsRan = true;
        }

        if (! $eventsRan) {
            $this->info('No scheduled commands are ready to run.');
        }
    }
}