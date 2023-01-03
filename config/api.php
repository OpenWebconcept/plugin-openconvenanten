<?php declare(strict_types=1);

return [
    'models' => [
        /**
         * Custom field creators.
         *
         * [
         *      'creator'   => CreatesFields::class,
         *      'condition' => \Closure
         * ]
         */
        'item'   => [
            'fields' => [
                'connected'   => Yard\OpenConvenanten\RestAPI\ItemFields\ConnectedField::class,
                'expired'     => Yard\OpenConvenanten\RestAPI\ItemFields\ExpiredField::class,
                'highlighted' => Yard\OpenConvenanten\RestAPI\ItemFields\HighlightedItemField::class,
                'taxonomies'  => Yard\OpenConvenanten\RestAPI\ItemFields\TaxonomyField::class,
                'image'       => Yard\OpenConvenanten\RestAPI\ItemFields\FeaturedImageField::class,
                'downloads'   => Yard\OpenConvenanten\RestAPI\ItemFields\DownloadsField::class,
                'links'       => Yard\OpenConvenanten\RestAPI\ItemFields\LinksField::class,
                'synonyms'    => Yard\OpenConvenanten\RestAPI\ItemFields\SynonymsField::class,
                'notes'       => Yard\OpenConvenanten\RestAPI\ItemFields\NotesField::class,
            ],
        ],
        'theme'  => [
            'fields' => [
                'connected' => Yard\OpenConvenanten\RestAPI\ItemFields\ConnectedThemeItemField::class,
            ],
        ],
        'search' => [
            'fields' => [
                'connected'  => Yard\OpenConvenanten\RestAPI\ItemFields\ConnectedField::class,
                'expired'    => Yard\OpenConvenanten\RestAPI\ItemFields\ExpiredField::class,
                'taxonomies' => Yard\OpenConvenanten\RestAPI\ItemFields\TaxonomyField::class,
                'image'      => Yard\OpenConvenanten\RestAPI\ItemFields\FeaturedImageField::class,
                'downloads'  => Yard\OpenConvenanten\RestAPI\ItemFields\DownloadsField::class,
                'links'      => Yard\OpenConvenanten\RestAPI\ItemFields\LinksField::class,
                'synonyms'   => Yard\OpenConvenanten\RestAPI\ItemFields\SynonymsField::class,
                'notes'      => Yard\OpenConvenanten\RestAPI\ItemFields\NotesField::class,
            ],
        ],
    ],
];
