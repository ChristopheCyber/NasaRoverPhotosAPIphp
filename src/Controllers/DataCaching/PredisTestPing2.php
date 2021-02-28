<?php
namespace Marsapi\Controllers\DataCaching;

use Predis;

require "predis/autoload.php";
//PredisAutoloader::register();

// since we connect to default setting localhost
// and 6379 port there is no need for extra
// configuration. If not then you can specify the
// scheme, host and port to connect as an array
// to the constructor.
try {
    //$redis = new Predis\Client();
    /**/
    $redis = new Predis\Client(array('host' => '127.0.0.1', 'port' => 6379));

    //check whether server is running or not
    echo "Server is running: " . $redis->ping() . "\n";
    echo "Successfully connected to Redis\n";

    $redis->set("hello_world", "Hi from PredisTestPing2.php");
    $value = $redis->get("hello_world");
    var_dump($value);

} catch (Exception $e) {
    echo "Couldn't connect to Redis in test ping 2";
    echo $e->getMessage();
}
