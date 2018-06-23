<?php

$container = container();

$container['Router'] = function () {
    return new \Root\Routing\Router();
};

$container['Server'] = function ($container) {
    return new \Root\Server($container['Router']);
};