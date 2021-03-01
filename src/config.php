<?php
return array(
    'startDate' => '2016-4-2',
    //startDate in 'YYYY-m-d' or 'YYYY-mm-dd' format
    //startDate put by default at '2016-4-2' if not filled (='' or not present)
    'config_Rover' => 'curiosity',
    'config_Camera' => 'NAVCAM', // Navigation Camera part of Curiosity Rover
    // infos: see Rover Cameras table on https://api.nasa.gov/ => Browse APIs => Mars Rover Photos
    'nasa_api' => array(
        'api_key' => 'DEMO_KEY',
        'api_url' => 'https://api.nasa.gov/mars-photos/api/v1/',
    ),
    'host' => 'localhost',
    'port' => 6379,
    // 'username' => 'user',
    // 'password' => '',
    // 'database' => '',
);
