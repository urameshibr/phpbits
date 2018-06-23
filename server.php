<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 21/06/2018
 * Time: 22:45
 */

$router = new \Root\Routing\Router();
$server = new \Root\Server($router);
$server->start();