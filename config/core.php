<?php declare(strict_types=1);

return [

    /**
     * Service Providers.
     */
    'providers' => [
        /**
         * Global providers.
         */
        Yard\OpenConvenanten\OpenConvenantenServiceProvider::class,
        Yard\OpenConvenanten\ElasticPress\ElasticPressServiceProvider::class,
        Yard\OpenConvenanten\GravityForms\GravityFormsServiceProvider::class,
        Yard\OpenConvenanten\Migrate\MigrateServiceProvider::class,
        Yard\OpenConvenanten\Taxonomy\TaxonomyServiceProvider::class,
        
        /**
         * Providers specific to the admin.
         */
        'admin' => [
            Yard\OpenConvenanten\Metabox\MetaboxServiceProvider::class
        ],
        'cli' => [
        ],
    ]
];
