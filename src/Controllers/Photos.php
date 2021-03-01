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
    const DEFAULT_ROVER = 'curiosity';
    //
    const CAMERA = 'camera';
    const DEFAULT_CAMERA = 'NAVCAM';
    //
    const DATE = 'dateChosen';
    const DEFAULT_DATE = '2016-4-2'; //Y-M-D
    //
    const DAY_RANGE = 'dayRange';
    const DEFAULT_DAY_RANGE = 10; //=10;
    //
    const MAX_PICS = 'max_pics';
    const DEFAULT_MAX_PICS_PER_DAY = 3;
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
                self::DATE => self::DEFAULT_DATE,
            ];
        }
        echo "\n*** in Photos showPhotos 58\n";

        return $this->getPhotos($params);
    }

    /**
     * @param $params
     * @return array
     */
    private function getPhotos($params)
    {
        echo "\n*** in Photos getPhotos 69\n";

        try {
            // $today = '2016-4-2' => date('Y-m-d')
            $today = $params[self::DATE];
            // echo "\n ///////////////////////// Photos getPhotos => today= *".$today."*\n";
            $result = [];
            echo ' $params[self::DAY_RANGE]=' . $params[self::DAY_RANGE];
            for ($i = $params[self::DAY_RANGE]; $i >= 0; $i--) {
                $date = date('Y-m-d', strtotime("-{$i} days", strtotime($today)));
                //key setting
                $key = $params[self::ROVER] . $params[self::CAMERA] . $params[self::MAX_PICS] . $date;
                echo "\n i=" . $i . ' => date=' . $date . ' => key=' . $key . "\n";
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
            echo "\n* Error in Caching process in Photos getPhotos * ";
            echo $e->getMessage();
        }

    }
}
