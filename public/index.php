<?php

require __DIR__ . '/../vendor/autoload.php';

//Instantiate application with configuration
$config = require __DIR__ . '/../src/config.php';
echo "\n*** index 7 require : config['host'] = *" . $config['host'] . "* <br/>\n";
print_r($config);

$app = new Marsapi\Application($config);
echo "\n*** index 11 app=new Application(config): app = *" . var_dump($app) . "* <br/>\n";
// var_dump($app);

$app->run();
