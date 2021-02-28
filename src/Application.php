<?php

namespace Marsapi;

use DI\Container;

/**
 * Class Application
 * @package Marsapi
 */
class Application
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var array
     */
    private $config;

    /**
     * Application constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->container = new Container();
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    public function run()
    {
        //echo php_sapi_name() <=> PHP_SAPI
        echo "\n*** Application run() 51: php_sapi_name = *" . php_sapi_name() . "* <br/>\n";
        //echo "\n phpinfo() =  ".phpinfo()." <br/>\n";
        //
        if (PHP_SAPI === 'cli') {
            $this->runCLI();
        } else {
            $this->runHTTP();
        }
    }
    //CLI command handler
    public function runCLI()
    {
        echo "\n* CLI started *";
        try {
            //route parser
            $class = $this->container->get('Marsapi\Controllers\Photos');
            $result = $class->showPhotos();
            echo "\n*** Application runCLI() 68: result = *" . $result . "* <br/>\n";
            var_dump($result);
        } catch (\Exception $e) {
            echo "\n* Error with DI *";
        }
        echo "\n* CLI ended *";
    }

    public function runHTTP()
    {
        $this->registerErrorHandler();

        //Boot Router
        $routes = require __DIR__ . '/routes.php';
        $response = $this->bootRouter($routes);
        echo "\n*** Application runHTTP() 84: response = *" . $response . "* <br/>\n";
        var_dump($response);
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function registerErrorHandler()
    {
        //could be placed in config
        $environment = 'development';

        $whoops = $this->container->get('\Whoops\Run');
        if ($environment !== 'production') {
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        } else {
            $whoops->pushHandler(function ($e) {
                echo "\n* Error that should be emailed to developer";
            });
        }
        $whoops->register();
    }

    /**
     * @param $routes
     * @return mixed
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Http\MissingRequestMetaVariableException
     */
    public function bootRouter($routes)
    {
        $router = $this->container->get('Marsapi\Router');
        return $router->boot($this->container, $routes);
    }
}
