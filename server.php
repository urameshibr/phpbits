<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 21/06/2018
 * Time: 22:45
 */

use \Root\Container\Container;
use \Root\Routing\Router;
use \Root\Server;

/**
 * @param string $path
 * @return string
 */
function root_path($path = '/')
{
    return __DIR__ . $path;
}

$container = Container::getInstance();
$router = Router::getInstance();
$server = Server::getInstance($router, $container);
$server->start();