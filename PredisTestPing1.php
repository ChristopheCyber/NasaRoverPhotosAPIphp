<?php
require "predis/autoload.php";
use Predis\Command\Command;
//PredisAutoloader::register();

// since we connect to default setting localhost
// and 6379 port there is no need for extra
// configuration. If not then you can specify the
// scheme, host and port to connect as an array
// to the constructor.
try {
    //$redis = new Predis\Client();
    /**/
    $redis = new Predis\Client(array(
        "scheme" => "tcp",
        "host" => "127.0.0.1",
        "port" => 6379));

    echo "Successfully connected to Redis";

    $redis->set("key1", "Hi from test0.php!");
    $redis->set("key1", "Hi from test0.php!");
    $value = $redis->get("key1");
    var_dump($value);
    $redis->rpush("key2","world 1");
    $redis->rpush("key2","world 2");
    $value2 = $redis->lrange("key2", 0, 1);
    var_dump($value2);
    $key3 = "countries";
    $redis->sadd($key3, ['france', 'germany', 'czechia']);
    $value3 = $redis->smembers($key3);
    var_dump($value3);

    echo ($redis->exists("Santa Claus")) ? "true" : "false";
} catch (Exception $e) {
    echo "Couldn't connect to Redis in test ping 1";
    echo $e->getMessage();
}
