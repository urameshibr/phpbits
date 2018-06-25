<?php

namespace Root\Container;

use Pimple\Container as Pimple;
use Root\Providers\ContainerProvider;

class Container extends Pimple
{
    private $handled = false;

    public static function getInstance()
    {
        static $instance = null;
        if (is_null($instance)) {
            $instance = new static();
        }
        if (!$instance->handled) $instance->handle();

        return $instance;
    }

    /**
     * @return $this
     */
    public function handle()
    {
        if (!$this->handled) {
            require_once(root_path("/src/config/container.php"));
            $this->register(new ContainerProvider());
            $this->handled = true;
        }

        return $this;
    }

    public function get(string $class)
    {
        if (!in_array($class, $this->getContainerMap())) return null;

        return $this[$class];
    }

    public function getContainerMap()
    {
        return $this->keys();
    }

    /**
     * @param string $bind_name
     * @param \Closure $closure
     * @throws \Exception
     */
    public function registerBind(string $bind_name, \Closure $closure)
    {
        try {
            $this[$bind_name] = $closure;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}