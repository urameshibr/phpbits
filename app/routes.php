<?php

$this->router->get('/', 'App\Http\Controllers\CustomerController@index');

$this->router->get('/test', function () {
    return 'Closure da rota test';
});