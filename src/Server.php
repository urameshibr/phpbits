<?php

namespace Root;

use Root\Routing\Router;

class Server
{
    /** @var Router $router */
    protected $router;

    public function start()
    {
        $this->router = new Router();
        require('../app/routes.php');

        die($this->router->handle());
    }
}