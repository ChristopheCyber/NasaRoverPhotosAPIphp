<?php

require __DIR__ . '/../vendor/autoload.php';

//Instantiate application with configuration
$config = require __DIR__ . '/../src/config.php';
echo "\n*** index 7 require : config['host'] = *" . $config['host'] . "* \n";
echo "config['nasa_api']['api_key']=".$config['nasa_api']['api_key'] . "* \n";
echo "config['nasa_api']['api_url']=".$config['nasa_api']['api_url'] . "* \n";
print_r($config);

$app = new Marsapi\Application($config);
echo "\n*** index 11 app=new Application(config)"
// . ": app = *" . var_dump($app) . "* \n"
;

$app->run();
