<?php

namespace Marsapi;

use DI\Container;

/**
 * Class Router
 * @package Marsapi
 */
class Router
{

    /**
     * @param Container $container
     * @param array $routes
     * @return mixed
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Http\MissingRequestMetaVariableException
     */
    public function boot(Container $container, array $routes)
    {
        //Class instantiations could be moved to Container
        $request = new \Http\HttpRequest($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
        $response = new \Http\HttpResponse();

        $routeDefinitionCallback = function (\FastRoute\RouteCollector $r) use ($routes) {
            foreach ($routes as $route) {
                $r->addRoute($route[0], $route[1], $route[2]);
            }
        };

        $dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);

        // if in .htaccess => no need of str_replace
        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            str_replace('/nasa_test/public', '', $request->getPath())
        );

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                $response->setContent('404 - Page not found');
                $response->setStatusCode(404);
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $response->setContent('405 - Method not allowed');
                $response->setStatusCode(405);
                break;
            case \FastRoute\Dispatcher::FOUND:
                $className = $routeInfo[1][0];
                $method = $routeInfo[1][1];
                $vars = $routeInfo[2];
                var_dump($className);
                $class = $container->get($className);
                $content = $class->$method($vars);
                //could be formated before in a $response->setContent($content)
                return $content;
                break;
        }
    }

}
