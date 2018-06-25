<?php

/** @var \Root\Container\Container $container */

$container = container();

try {
    $container->registerBind('Test', function () {
        return new \App\Models\Test();
    });
    $container->registerBind('Router', function () {
        return \Root\Routing\Router::getInstance();
    });
    /**
     * @param \Root\Container\Container $container
     * @return \Root\Server
     */
    $container->registerBind('Server', function (\Root\Container\Container $container) {
        return new \Root\Server($container['Router'], $this);
    });
} catch (Exception $exception) {
    throw $exception;
}


