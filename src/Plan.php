<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 18/3/6
 * Time: 下午3:16
 */

namespace Snower\LaravelForsun;


class Plan
{
    protected $forsun_pan;
    protected $removed;

    public function __construct($forsun_pan, $removed = false)
    {
        $this->forsun_pan = $forsun_pan;
        $this->removed = $removed;
    }
}