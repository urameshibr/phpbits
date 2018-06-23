<?php

if (!function_exists('container')) {
    function container($bind_name = '')
    {
        return new \Pimple\Container();
    }
}