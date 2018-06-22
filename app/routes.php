<?php

$this->router->get('/', function(){

    return new \App\Models\Test(); // json encoded

});

$this->router->get('/controller', 'App\Http\Controllers\CustomerController@index');

$this->router->get('/test', function () {

    return $this->router; //json encoded

});