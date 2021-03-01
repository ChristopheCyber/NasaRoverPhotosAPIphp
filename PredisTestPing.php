<?php
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
    $redis = new Predis\Client(array(
        "scheme" => "tcp",
        "host" => "127.0.0.1",
        "port" => 6379));

    /** Ping test: */
    //check whether server is running or not
    echo "Server is running: " . $redis->ping() . "\n"; 
    // Same as : ping in Predis console (cmd: $ redis-cli) => 
    // sould answer PONG in Predis monitor (cmd: $ redis-cli monitor)
    echo "\n* Successfully connected to Redis *\n";

    /** Some basic tests: */
    $redis->set("key0", "Hello from PredisTestPing.php");
    $value1 = $redis->get("key0");
    var_dump($value1);
    //
    $redis->rpush("keyBis","Hello");
    $redis->rpush("keyBis","World !");
    $value2 = $redis->lrange("keyBis", 0, 1);
    var_dump($value2);

} catch (Exception $e) {
    echo "Couldn't connect to Redis in test PredisTestPing.php";
    echo $e->getMessage();
}
