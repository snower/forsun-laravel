<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 18/3/7
 * Time: 下午4:12
 */

namespace Snower\LaravelForsun\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;

class JobDispatchHandler implements ShouldQueue
{
    public function handle($job){
        dispatch(is_string($job) ? resolve($job) : $job);
    }
}