<?php

namespace Snower\LaravelForsun;

use Carbon\Carbon;

trait ManagesFrequencies
{
    protected function createPlan($second = 1, $minute = -1, $hour = -1, $day = -1, $month = -1, $week = -1){
        $this->second = $second;
        $this->minute = $minute;
        $this->hour = $hour;
        $this->day = $day;
        $this->month = $month;
        $this->week  = $week;
        $this->is_timeout = false;
        $this->timeout_count = 0;

        $this->timed = true;
        return $this->schedule();
    }

    protected function createTimeoutPlan($count = 1, $second = 1, $minute = 0, $hour = 0, $day = 0, $month = 0, $week = 0){
        $this->second = $second;
        $this->minute = $minute;
        $this->hour = $hour;
        $this->day = $day;
        $this->month = $month;
        $this->week  = $week;
        $this->is_timeout = true;
        $this->timeout_count = $count;

        $this->timed = true;
        return $this->schedule();
    }

    /**
     * Schedule the event to run hourly.
     *
     * @return $this
     */
    public function hourly()
    {
        return $this->createPlan(0, 0);
    }

    /**
     * Schedule the event to run hourly at a given offset in the hour.
     *
     * @param  int|string|array  $offset
     * @return $this
     */
    public function hourlyAt($offset)
    {
        if(is_string($offset)){
            $segments = explode(':', $offset);
        }else if(is_numeric($offset)){
            $segments = [intval($offset)];
        }else{
            $segments = array($offset);
        }
        return $this->createPlan(count($segments) >= 2 ? intval($segments[1]) : 0, intval($segments[0]));
    }

    /**
     * Schedule the event to run daily.
     *
     * @return $this
     */
    public function daily()
    {
        return $this->createPlan(0, 0, 0);
    }

    /**
     * Schedule the command at a given time.
     *
     * @param  string|int|Carbon  $time
     * @return $this
     */
    public function at($time)
    {
        if(is_string($time)){
            $time = strtotime($time);
        }

        if(is_numeric($time)){
            $time = Carbon::createFromTimestamp($time);
        }

        $time->setTimezone("UTC");

        return $this->createPlan($time->second, $time->minute, $time->hour, $time->day, $time->month);
    }

    /**
     * Schedule the event to run daily at a given time (10:00, 19:30, etc).
     *
     * @param  string  $time
     * @return $this
     */
    public function dailyAt($time)
    {
        if(is_string($time)){
            $segments = explode(':', $time);
        }else if(is_numeric($time)){
            $segments = [intval($time)];
        }else{
            $segments = array($time);
        }
        return $this->createPlan(count($segments) >= 3 ? intval($segments[2]) : 0, count($segments) >= 2 ? intval($segments[1]) : 0, intval($segments[0]));
    }

    /**
     * Schedule the event to run monthly.
     *
     * @return $this
     */
    public function monthly()
    {
        return $this->createPlan(0, 0, 0, 1);
    }

    /**
     * Schedule the event to run monthly on a given day and time.
     *
     * @param  int  $day
     * @param  string  $time
     * @return $this
     */
    public function monthlyOn($day = 1, $time = '0:0:0')
    {
        if(is_string($time)){
            $segments = explode(':', $time);
        }else if(is_numeric($time)){
            $segments = [intval($time)];
        }else{
            $segments = array($time);
        }
        return $this->createPlan(count($segments) >= 3 ? intval($segments[2]) : 0, count($segments) >= 2 ? intval($segments[1]) : 0, intval($segments[0]), $day);
    }

    /**
     * Schedule the event to run every minute.
     *
     * @return $this
     */
    public function everyMinute($count = 0)
    {
        return $this->createTimeoutPlan($count, 0, 1);
    }

    /**
     * Schedule the event to run every five minutes.
     *
     * @return $this
     */
    public function everyFiveMinutes($count = 0)
    {
        return $this->createTimeoutPlan($count, 0, 5);
    }

    /**
     * Schedule the event to run every ten minutes.
     *
     * @return $this
     */
    public function everyTenMinutes($count = 0)
    {
        return $this->createTimeoutPlan($count, 0, 10);
    }

    /**
     * Schedule the event to run every thirty minutes.
     *
     * @return $this
     */
    public function everyThirtyMinutes($count = 0)
    {
        return $this->createTimeoutPlan($count, 0, 30);
    }

    public function interval($seconds, $count = 0){
        $minute = 0;
        $hour = 0;
        $day = 0;
        if($seconds > 60){
            $minute = intval($seconds / 60);
            $seconds = $seconds % 60;
        }

        if($minute > 60){
            $hour = intval($minute / 60);
            $minute = $minute % 60;
        }

        if($hour > 24){
            $day = intval($hour / 24);
            $hour = $hour % 24;
        }

        return $this->createTimeoutPlan($count, $seconds, $minute, $hour, $day);
    }

    public function later($seconds){
        return $this->interval($seconds, 1);
    }

    public function delay($seconds){
        return $this->later($seconds);
    }
}
