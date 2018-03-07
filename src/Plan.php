<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 18/3/6
 * Time: 下午3:16
 */

namespace Snower\LaravelForsun;

use Carbon\Carbon;

class Plan
{
    protected $forsun;
    protected $forsun_pan;
    protected $removed;

    public function __construct($forsun, $forsun_pan, $removed = false)
    {
        $this->forsun = $forsun;
        $this->forsun_pan = $forsun_pan;
        $this->removed = $removed;
    }

    public function getName(){
        return $this->forsun_pan->key;
    }

    public function getNextRunTime(){
        return Carbon::createFromTimestamp($this->forsun_pan->next_time);
    }

    public function remove(){
        $this->forsun->remove($this->forsun_pan->key);
        $this->removed = true;
        return true;
    }

    public function isRemoved(){
        return $this->removed;
    }
}