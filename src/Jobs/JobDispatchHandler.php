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
    public $job;

    public function __construct($job)
    {
        $this->job = $job;
    }

    public function handle(){
        dispatch(is_string($this->job) ? resolve($this->job) : $this->job);
    }
}