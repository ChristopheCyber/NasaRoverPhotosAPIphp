<?php

require __DIR__ . '/../vendor/autoload.php';

//Instantiate application with configuration
$config = require __DIR__ . '/../src/config.php';
echo "\n*** index ; config.php = \n";
print_r($config);

$app = new Marsapi\Application($config);
echo "\n*** index ; app = new Application(config) \n"
// . ": app = *" . var_dump($app) . "* \n"
;

$app->run();
