<?php

namespace Marsapi\Controllers\DataCaching;

use Predis;

/**
 * Class MemCache
 * @package Marsapi\Cache
 */
class MemCache
{
    /**
     * @var \Memcached
     */
    private $memcache;

    /**
     * MemCache constructor.
     * Predis/Redis cache server as alternative to Memcache deprecated on Windows OS
     */
    public function __construct()
    {
        // Memcached() is deprecated on Windows => Redis is good alternative
        // $this->memcache = new \Memcached();
        // $this->memcache->addServer('localhost', 11211); 
        //REDIS

        /**
         * //Connecting to Redis server on 'localhost'='127.0.0.1' / port 6379
         * // general template sample :
         * $redis = new Predis\Client();
         * $redis->connect('127.0.0.1', 6379);
         * // 
         * $redis1 = new Predis\Client(array('host' => '127.0.0.1', 'port' => 6379));
         * echo "Connection to server sucessfully";
         * //check whether server is running or not
         * echo "Server is running: ".$redis->ping();
         */

        //Connecting to Predis/Redis server on localhost
        require "predis/autoload.php";
        // 'host' & 'port' could be read from config
        $this->memcache = new Predis\Client(array('host' => '127.0.0.1', 'port' => 6379));

    }

    /**
     * @param $key
     * @param $var
     */
    public function setCache($key, $var)
    {
        echo "\n*** in MemCache setCache \n";
        /*
        echo "\n*** in MemCache setCache 59 var_dump(key) = \n******\n";
        var_dump($key);
        echo "\n******\n";
        echo "\n*** in MemCache setCache 62 var_dump(var) = \n******\n";
        var_dump($var);
        echo "\n******\n";
        echo "\n*** in MemCache setCache 65 var_dump( json_encode(var) ) = \n******\n";
        $stringVar = json_encode($var);
        var_dump($stringVar);
        echo "\n****** json_decode() => \n";
        var_dump(json_decode($stringVar, true));
        echo "\n******\n";
         */
        $encode_var = json_encode($var);
        $this->memcache->set($key, $encode_var);

    }

    /**
     * @param $key
     * @return mixed
     */
    public function getCache($key)
    {
        echo "\n*** in MemCache getCache key = \n******\n";
        var_dump($key);
        echo "\n******\n";
        $getResp = $this->memcache->get($key);
        // echo "\n*** in MemCache getCache getResp = memcache->get(key) = \n******\n";
        // var_dump($getResp);
        // echo "\n******\n";
        /*
        $getRespJson = json_decode($getResp);
        echo "\n*** in MemCache getCache 82 var_dump( getRespJson = json_decode(getResp) ) = \n******\n";
        var_dump($getRespJson);
        echo "\n******\n";
         */
        return json_decode($this->memcache->get($key));
    }

}
