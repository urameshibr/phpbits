<?php

declare(strict_types=1);

require('../vendor/autoload.php');

function public_path($path = '')
{
    return __DIR__ . $path;
}

require('../server.php');