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

class ScheduleUnregisterCommand extends Command
{
    protected $name = 'forsun:schedule:unregister';
    protected $description = 'unregister schedule:run';

    public function handle(){
        $forsun = Container::getInstance()->make('forsun');
        $name = config('forsun.prefix') . ':schedule:run';
        $forsun->remove($name);
        $this->info("success");
    }
}