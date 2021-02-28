<?php

namespace Marsapi\Controllers\DataCaching;

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
     */
    public function __construct()
    {
        // Memcached() is deprecated on Windows => Redis is good alternative
        // $this->memcache = new \Memcached();
        // $this->memcache->addServer('localhost', 11211); //could be in config
        //REDIS
        /** //Connecting to Redis server on localhost
         *  $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        echo "Connection to server sucessfully";
        //check whether server is running or not
        echo "Server is running: ".$redis->ping();
         */
        //Connecting to Redis server on localhost
        $this->memcache = new Redis();
        $this->memcache->connect('127.0.0.1', 6379);
        echo "Connection to Redis server sucessfully";
        //check whether server is running or not
        echo "Server is running: " . $this->memcache->ping();
    }

    /**
     * @param $key
     * @param $var
     * @param int $expire
     */
    public function setCache($key, $var, $expire = 0)
    {
        $this->memcache->set($key, $var, $expire);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getCache($key)
    {
        return $this->memcache->get($key);
    }

}
