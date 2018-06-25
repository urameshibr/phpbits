<?php

namespace Root;

use Root\Routing\Router;
use Root\Container\Container as RootContainer;

class Server
{
    /** @var Router $router */
    protected $router;
    private $attributes = [];
    private $container;

    public function __construct(Router $router, RootContainer $container)
    {
        $this->container = $container;
        $this->setAttributes();
        $this->router = $router;
    }

    /**
     * @param Router $router
     * @param RootContainer $container
     * @return null|Server
     */
    public static function getInstance(Router $router, RootContainer $container)
    {
        static $instance = null;
        if (is_null($instance)) {
            $instance = new static($router, $container);
        }

        return $instance;
    }

    public function start()
    {
        $this->container->handle();

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