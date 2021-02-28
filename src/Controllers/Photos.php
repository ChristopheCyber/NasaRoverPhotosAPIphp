<?php

namespace Marsapi\Controllers;

use Marsapi\Controllers\DataCaching\MemCache;
use Marsapi\Model\MarsapiWrapper;

/**
 * Class Photos
 * @package Marsapi\Controllers
 */
class Photos
{

    const ROVER = 'rover';
    const CAMERA = 'camera';
    const DAY_RANGE = 'dayRange';
    const MAX_PICS = 'NbrPicsMax';
    const DEFAULT_MAX_PICS_PER_DAY = 3;
    const DEFAULT_ROVER = 'curiosity';
    const DEFAULT_CAMERA = 'NAVCAM';
    const DEFAULT_DAY_RANGE = 2;
    // const DEFAULT_DAY_RANGE = 10;
    /**
     * @var MarsapiWrapper
     */
    private $nasaApi;
    /**
     * @var MemCache
     */
    private $cache;

    /**
     * Photos constructor.
     * @param MarsapiWrapper $nasaApi
     * @param MemCache $cache
     */
    public function __construct(MarsapiWrapper $nasaApi, MemCache $cache)
    {
        $this->nasaApi = $nasaApi;
        $this->cache = $cache;
    }

    /**
     * @param array $params
     * @return array
     */
    public function showPhotos($params = [])
    {
        if (empty($params)) {
            $params = [
                self::ROVER => self::DEFAULT_ROVER,
                self::CAMERA => self::DEFAULT_CAMERA,
                self::DAY_RANGE => self::DEFAULT_DAY_RANGE,
                self::MAX_PICS => self::DEFAULT_MAX_PICS_PER_DAY,
            ];
        }

        return $this->getPhotos($params);
    }

    /**
     * @param $params
     * @return array
     */
    private function getPhotos($params)
    {
        try {
            //$today = date('Y-m-d');
            $today = '2016-4-2';
            $result = [];

            for ($i = $params[self::DAY_RANGE]; $i >= 0; $i--) {
                $date = date('Y-m-d', strtotime("-{$i} days", strtotime($today)));
                //key setting
                $key = $params[self::ROVER] . $params[self::CAMERA] . $params[self::MAX_PICS] . $date;
                //cache retrieving
                if ($this->cache->getCache($key)) {
                    $result[$date] = $this->cache->getCache($key);
                    continue;
                }
                $result[$date] = $this->nasaApi->getPhotos($params, $date);
                $this->cache->setCache($key, $result);
            }
            return $result;
        } catch (\Exception $e) {
            echo '\n* Error in Caching process during getting Photos *';
            echo $e->getMessage();
        }

    }
}
