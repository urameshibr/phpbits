<?php

namespace Root\Providers;

use App\Models\Test;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ContainerProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['Test_container_1'] = function () {
            return new Test();
        };
        $pimple['Test_container_2'] = function () {
            return new Test();
        };
    }
}