<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 21/06/2018
 * Time: 22:45
 */

require(__DIR__.'/src/config/container.php');

$server = $container['Server'];
$server->start();