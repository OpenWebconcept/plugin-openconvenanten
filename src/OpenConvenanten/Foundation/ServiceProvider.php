<?php

declare(strict_types=1);

namespace Yard\OpenConvenanten\Foundation;

abstract class ServiceProvider
{
    protected Plugin $plugin;

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Register the service provider.
     */
    abstract public function register();
}
