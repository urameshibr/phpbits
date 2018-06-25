<?php

if (!function_exists('container')) {
    /**
     * @return null|\Root\Container\Container
     */
    function container()
    {
        return \Root\Container\Container::getInstance();
    }
}

if (!function_exists('dj')) {
    /**
     * @param $response
     * @return void
     */
    function dj($response)
    {
        header('Content-type: Application/json');
        var_dump($response);
        die();
    }
}