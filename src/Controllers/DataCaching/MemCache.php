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
     * Memcache deprecated on Windows OS, Redis as alternative
     * both not installing correctly on Windows as global system variables
     * TODO : considering HTTP header control-cach caching as alternative
     */
    public function __construct()
    {
        // Memcached() is deprecated on Windows => Redis is good alternative
        // $this->memcache = new \Memcached();
        // $this->memcache->addServer('localhost', 11211); //could be in config
        //REDIS

        /**
         * //Connecting to Redis server on 'localhost'='127.0.0.1' / port 6379
         * //template sample :
         * $redis = new Redis();
         * $redis->connect('127.0.0.1', 6379);
         * $redis1 = new Predis\Client(array('host' => '127.0.0.1', 'port' => 6379));
         * echo "Connection to server sucessfully";
         * //check whether server is running or not
         * echo "Server is running: ".$redis->ping();
         */

        //Connecting to Redis server on localhost
        //$this->memcache = new Redis();
        // $this->memcache->connect('127.0.0.1', 6379);
        require "predis/autoload.php";

        $this->memcache = new Predis\Client(array('host' => '127.0.0.1', 'port' => 6379));

    }

    /**
     * @param $key
     * @param $var
     * @param int $expire
     */
    public function setCache($key, $var, $expire = 10){
        echo "\n*** in MemCache setCache 58\n";
        echo "\n*** key=".$key.";  var=".$var.";  expire=".$expire."\n";
        echo "\n*** in MemCache setCache 60 var_dump(key) = \n******\n"; 
        var_dump($key);
        echo "\n******\n";
        echo "\n*** in MemCache setCache 63 var_dump(var) = \n******\n"; 
        var_dump($var);
        echo "\n******\n";
        echo "\n*** in MemCache setCache 66 var_dump(expire) = \n******\n";
        var_dump($expire);
        echo "\n******\n";
        echo "\n*** in MemCache setCache 69 var_dump( json_encode(var) ) = \n******\n";
        $stringVar = json_encode($var);
        var_dump($stringVar);
        echo "\n****** json_decode() => \n";
        var_dump(json_decode($stringVar, true));
        echo "\n******\n";
        echo "\nvar[2016-03-31][0]=".$var["2016-03-31"][0];
        echo "\nstrval( var[2016-03-31][0] )=".strval($var["2016-03-31"][0]);
        $var1 = $var["2016-03-31"][0];
        $this->memcache->set($key, $var1);
        // $this->memcache->set($key, strval($var["2016-03-31"][0]), $expire);
        // $this->memcache->set($key, $var["2016-03-31"][0], $var["2016-03-31"][1], $var["2016-03-31"][2], $expire);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getCache($key) {
        echo "\n*** in MemCache getCache 77\n";
        echo "\n*** in MemCache getCache 78 var_dump(key) = \n******\n"; 
        var_dump($key);
        echo "\n******\n";
        $getResp = $this->memcache->get($key);
        echo "\n*** in MemCache getCache 82 var_dump( getResp = memcache->get(key) ) = \n******\n"; 
        var_dump($getResp);
        echo "\n******\n";
        $getRespJson = json_decode($getResp);
        echo "\n*** in MemCache getCache 82 var_dump( getRespJson = json_decode(getResp) ) = \n******\n"; 
        var_dump($getRespJson);
        echo "\n******\n";
        return json_decode($this->memcache->get($key));
    }

}
