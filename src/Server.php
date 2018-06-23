<?php

namespace Root;

use Root\Routing\Router;

class Server
{
    /** @var Router $router */
    protected $router;
    private $attributes = [];

    public function __construct(Router $router)
    {
        $this->setAttributes();
        $this->router = $router;
    }

    public function start()
    {
        require('../app/routes.php');

        die($this->router->handle($this->attributes['REDIRECT_URL'], $this->attributes));
    }

    public function setAttributes()
    {
        $this->attributes = $_SERVER;
        $this->attributes['REDIRECT_URL'] = empty($_SERVER['REDIRECT_URL']) ? '/' : $_SERVER['REDIRECT_URL'];
    }

    public function getAttribute(string $attribute = '')
    {
        if (empty($attribute)) return null;

        return array_key_exists($attribute, $this->attributes)
            ? $this->attributes[$attribute]
            : null;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
}