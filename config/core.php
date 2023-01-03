<?php declare(strict_types=1);

return [

    /**
     * Service Providers.
     */
    'providers'    => [
        /**
         * Global providers.
         */
        Yard\OpenConvenanten\OpenConvenantenServiceProvider::class,
        Yard\OpenConvenanten\ElasticPress\ElasticPressServiceProvider::class,
        Yard\OpenConvenanten\GravityForms\GravityFormsServiceProvider::class,
        /**
         * Providers specific to the admin.
         */
        'admin' => [

        ],
        'cli'   => [
        ],
    ]
];
