<?php

$this->router->get('/', '\Root\Routing\Controller@index');

$this->router->get('/test', function () {
    return 'Closure da rota test';
});