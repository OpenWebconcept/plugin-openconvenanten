<?php

declare(strict_types=1);

namespace Yard\OpenConvenanten\Migrate;

use Yard\OpenConvenanten\Foundation\ServiceProvider;

class MigrateServiceProvider extends ServiceProvider
{
    public function register()
    {
        (new MigrateToCMB2())->register();
    }
}
