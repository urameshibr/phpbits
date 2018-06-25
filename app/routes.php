<?php

$this->router->get('/', function () {

    $a = container()->get('Test');
    dj($a);
});

$this->router->get('/controller', 'App\Http\Controllers\CustomerController@index');

$this->router->get('/test', function () {

    return $this->router; //json encoded

});