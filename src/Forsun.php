<?php
/**
 * Created by PhpStorm.
 * User: snower
 * Date: 18/3/6
 * Time: 上午11:38
 */

namespace Snower\LaravelForsun;

use Illuminate\Support\Collection;
use Thrift\Transport\TSocket;
use Thrift\Transport\TBufferedTransport;
use Thrift\Protocol\TBinaryProtocol;
use Snower\LaravelForsun\Client\ForsunClient;
use Snower\LaravelForsun\Client\ForsunPlanError;

class Forsun
{

    protected $config;
    protected $socket = null;
    protected $transport = null;
    protected $protocol = null;
    protected $client = null;

    public function __construct($config)
    {
        $this->config = new Collection($config);
        $this->socket = null;
        $this->transport = null;
        $this->protocol = null;
        $this->client = null;
    }

    protected function getClient(){
        if($this->client == null){
            $this->makeClient();
        }

        if($this->socket == null || !$this->socket->isOpen()){
            $this->makeClient();
        }

        if(empty($this->client)){
            throw new ForsunPlanError([
                'code' => -1,
                'message' => 'network error'
            ]);
        }

        return $this->client;
    }

    protected function makeClient()
    {
        $this->socket = new TSocket($this->config->get('host', '127.0.0.1'), $this->config->get("port", 6458));
        $this->transport = new TBufferedTransport($this->socket, 1024, 1024);
        $this->protocol= new TBinaryProtocol($this->transport);

        $this->socket->setSendTimeout(5000);
        $this->socket->setRecvTimeout(120000);
        $this->transport->open();

        $this->client = new ForsunClient($this->protocol);
    }

    public function ping(){
        return $this->getClient()->ping();
    }

    public function create($key, $second, $minute, $hour, $day, $month, $week, $action, array $params){
        $forsun_pan = $this->getClient()->create($key, $second, $minute, $hour, $day, $month, $week, $action, $params);
        return new Plan($forsun_pan);
    }

    public function createTimeout($key, $second, $minute, $hour, $day, $month, $week, $count, $action, array $params){
        $forsun_pan = $this->getClient()->createTimeout($key, $second, $minute, $hour, $day, $month, $week, $count, $action, $params);
        return new Plan($forsun_pan);
    }

    public function remove($key){
        $forsun_pan = $this->getClient()->remove($key);
        return new Plan($forsun_pan, true);
    }

    public function get($key){
        $forsun_pan = $this->getClient()->get($key);
        return new Plan($forsun_pan);
    }

    public function getCurrent(){
        $forsun_pans = $this->getClient()->getCurrent();
        $plans = [];
        foreach ($forsun_pans as $forsun_pan){
            $plans[] = new Plan($forsun_pan);
        }
        return $plans;
    }

    public function getTime($timestamp){
        $forsun_pans = $this->getClient()->getTime($timestamp);
        $plans = [];
        foreach ($forsun_pans as $forsun_pan){
            $plans[] = new Plan($forsun_pan);
        }
        return $plans;
    }

    public function getKeys($prefix){
        return $this->getClient()->getKeys($prefix);
    }

    public function plan($name = null){
        return new Builder($this, $name);
    }
}