<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 18/3/6
 * Time: 下午3:23
 */

namespace Snower\LaravelForsun;


class Builder
{
    protected $forsun;
    protected $name;

    public function __construct($forsun, $name)
    {
        $this->forsun = $forsun;
        $this->name = $name;
    }
}