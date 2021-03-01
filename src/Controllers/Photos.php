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
    // const DEFAULT_ROVER = 'opportunity';
    // const DEFAULT_ROVER = 'spirit';
    
    const CAMERA = 'camera';
    const DEFAULT_CAMERA = 'NAVCAM'; // Navigation Camera (part of curiosity, opportunity, spirit)
    // const DEFAULT_CAMERA = 'FHAZ'; // Front Hazard Avoidance Camera (part of curiosity, opportunity, spirit)
    // const DEFAULT_CAMERA = 'MAST'; // Mast Camera (part of curiosity)
    // const DEFAULT_CAMERA = 'PANCAM'; // Panoramic Camera (part of opportunity, spirit)
    // for more options: see Rover Cameras table on https://api.nasa.gov/ => Browse APIs => Mars Rover Photos
    //
    const DATE = 'dateChosen';
    const DEFAULT_DATE = '2016-4-2';
    //
    const DAY_RANGE = 'dayRange';
    const DEFAULT_DAY_RANGE = 10;
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
            echo "\n!! => today0=" . $today . "* \n";
            $config1 = require __DIR__ . '/../config.php';
            echo "\nPhotos showPhotos config1['startDate']=" . $config1['startDate'] . "* \n";
            if ($config1['startDate']) {
                echo "\n!!date present in config :" . $config1['startDate'] . "* \n";
                $today = $config1['startDate'];
                echo "\n!! => today1=" . $today . "* \n";
            }

            echo "\n*** Photos getPhotos => today= *" . $today . "*\n";
            echo '\n*** DAY_RANGE = *' . $params[self::DAY_RANGE] . "*\n";
            $result = [];
            for ($i = $params[self::DAY_RANGE] - 1; $i >= 0; $i--) {
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
