<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 18/3/7
 * Time: 下午5:54
 */

namespace Snower\LaravelForsun\Commands;

use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Snower\LaravelForsun\Jobs\ScheduleRunHandler;

class ScheduleRegisterCommand extends Command
{
    protected $name = 'forsun:schedule:register';
    protected $description = 'register schedule:run';

    public function handle(){
        $forsun = Container::getInstance()->make('forsun');
        $name = ':schedule:run';
        $forsun->plan($name)->everyMinute()->job(new ScheduleRunHandler());
        $this->info("success");
    }
}