<?php

declare(strict_types=1);

return [
    'convenanten_base' => [
        'id'         => 'openconvenanten_metadata',
        'title'      => __('Data', OCV_LANGUAGE_DOMAIN),
        'post_types' => ['openconvenant-item'],
        'context'    => 'normal',
        'priority'   => 'high',
        'autosave'   => true,
        'validation' => [
            'rules'  => [
                'convenant_ID'                  => [
                    'required'  => true,
                ],
                'convenant_Samenvatting'        => [
                    'required'  => true,
                ],
                'convenant_Partijen'            => [
                    'required'  => true,
                ],

                'convenant_Onderwerp'           => [
                    'required'  => true,
                ],
                'convenant_Beleidsterrein'      => [
                    'required'  => true,
                ],
                'convenant_Duur'                => [
                    'required'  => true,
                ],
                'convenant_Datum_ondertekening' => [
                    'required'  => true,
                ],
                'convenant_Inhoud'              => [
                    'required'  => true,
                ],
                'convenant_Bijlagen'            => [
                    'required'  => true,
                ],
            ],
        ],
        'fields'     => [
            [
                'name' => __('Zaaknummer', OCV_LANGUAGE_DOMAIN),
                'id'   => 'convenant_ID',
                'type' => 'text',
            ],
            [
                'name' => __('Samenvatting', OCV_LANGUAGE_DOMAIN),
                'id'   => 'convenant_Samenvatting',
                'type' => 'textarea',
            ],
            [
                'name'              => 'Partijen',
                'id'                => 'convenant_Partijen',
                'type'              => 'group',
                'clone_as_multiple' => true,
                'clone'             => true,
                'fields'            => [
                    [
                        'name' => __('Naam', OCV_LANGUAGE_DOMAIN),
                        'id'   => 'convenant_Partijen_Naam',
                        'type' => 'text',
                    ],
                ],
            ],
            [
                'name' => __('Onderwerp', OCV_LANGUAGE_DOMAIN),
                'id'   => 'convenant_Onderwerp',
                'type' => 'text',
            ],
            [
                'name'    => __('Beleidsterrein', OCV_LANGUAGE_DOMAIN),
                'id'      => 'convenant_Beleidsterrein',
                'type'    => 'select',
                'desc'    => 'Dit zijn voorbeeldopties',
                'options' => [
                    'Economie'   => 'Economie',
                    'Onderwijs'  => 'Onderwijs',
                    'Wonen'      => 'Wonen',
                    'Zorg'       => 'Zorg',
                    'Veiligheid' => 'Veiligheid',
                    'Ruimte'     => 'Ruimte',
                    'Cultuur'    => 'Cultuur',
                    'Sport'      => 'Sport',
                    'Milieu'     => 'Milieu',
                    'Overig'     => 'Overig',
                ],
            ],
            [
                'name' => __('Duur', OCV_LANGUAGE_DOMAIN),
                'id'   => 'convenant_Duur',
                'type' => 'text',
            ],
            [
                'name' => __('Datum ondertekening', OCV_LANGUAGE_DOMAIN),
                'id'   => 'convenant_Datum_ondertekening',
                'type' => 'date',
            ],
            [
                'name' => __('Inhoud', OCV_LANGUAGE_DOMAIN),
                'id'   => 'convenant_Inhoud',
                'type' => 'textarea',
            ],
            [
                'name'              => __('Bijlagen', OCV_LANGUAGE_DOMAIN),
                'id'                => 'convenant_Bijlagen',
                'desc'              => 'Bijlagen kunnen worden toegevoegd als URL of als bestand. Als beide aanwezig zijn, wordt het bestand getoond.',
                'type'              => 'group',
                'clone_as_multiple' => true,
                'clone'             => true,
                'fields'            => [
                    [
                        'name'             => __('Bestand', OCV_LANGUAGE_DOMAIN),
                        'id'               => 'convenant_Bijlagen_Bestand',
                        'type'             => 'file',
                        'max_file_uploads' => 1,
                    ],
                    [
                        'name' => __('URL', OCV_LANGUAGE_DOMAIN),
                        'id'   => 'convenant_Bijlagen_URL',
                        'type' => 'text',
                    ],
                    [
                        'name' => __('Naam', OCV_LANGUAGE_DOMAIN),
                        'id'   => 'convenant_Bijlagen_Naam',
                        'type' => 'text',
                    ],
                ],
            ],
        ],
    ],
];
