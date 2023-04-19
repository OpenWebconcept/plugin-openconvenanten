<?php

declare(strict_types=1);

return [
    'convenanten_base' => [
        'id' => 'openconvenanten_metadata',
        'title' => __('Data', OCV_LANGUAGE_DOMAIN),
        'object_types' => ['openconvenant-item'],
        'context' => 'normal',
        'priority' => 'high',
        'autosave' => true,
        'fields' => [
            'general' => [
                [
                    'name' => __('Zaaknummer (ID) *', OCV_LANGUAGE_DOMAIN),
                    'id' => 'convenant_Zaaknummer_ID',
                    'type' => 'text',
                    'attributes' => [
                        'required' => 'required',
                    ],
                ],
                [
                    'name' => __('Onderwerp *', OCV_LANGUAGE_DOMAIN),
                    'id' => 'convenant_Onderwerp',
                    'type' => 'text',
                    'attributes' => [
                        'required' => 'required',
                    ],
                ],
                [
                    'name' => __('Samenvatting *', OCV_LANGUAGE_DOMAIN),
                    'id' => 'convenant_Samenvatting',
                    'type' => 'textarea',
                    'attributes' => [
                        'required' => 'required',
                    ],
                ],
                [
                    'classes' => 'additional-class',
                    'id' => 'convenant_Partijen_bij_convenant',
                    'type' => 'group',
                    'before_group' => sprintf('<div class="cmb-row"><div class="cmb-th"><label>%s</label></div></div>', __('Partijen bij convenant', OCV_LANGUAGE_DOMAIN)),
                    'clone' => true,
                    'options' => [
                        'group_title' => sprintf('%s %s', __('Partij', OCV_LANGUAGE_DOMAIN), '{#}'),
                        'add_button' => __('Voeg partij toe', OCV_LANGUAGE_DOMAIN),
                        'remove_button' => __('Verwijder partij', OCV_LANGUAGE_DOMAIN)
                    ],
                    'fields' => [
                        [
                            'name' => __('Naam *', OCV_LANGUAGE_DOMAIN),
                            'id' => 'convenant_Partijen_Naam',
                            'type' => 'text',
                            'attributes' => [
                                'required' => 'required',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => __('Beleidsterrein *', OCV_LANGUAGE_DOMAIN),
                    'id' => 'convenant_Beleidsterrein',
                    'type' => 'select',
                    'options' => [
                        'Economie' => __('Economie', OCV_LANGUAGE_DOMAIN),
                        'Onderwijs' => __('Onderwijs', OCV_LANGUAGE_DOMAIN),
                        'Wonen' => __('Wonen', OCV_LANGUAGE_DOMAIN),
                        'Zorg' => __('Zorg', OCV_LANGUAGE_DOMAIN),
                        'Veiligheid' => __('Veiligheid', OCV_LANGUAGE_DOMAIN),
                        'Ruimte' => __('Ruimte', OCV_LANGUAGE_DOMAIN),
                        'Cultuur' => __('Cultuur', OCV_LANGUAGE_DOMAIN),
                        'Sport' => __('Sport', OCV_LANGUAGE_DOMAIN),
                        'Milieu' => __('Milieu', OCV_LANGUAGE_DOMAIN),
                        'Overig' => __('Overig', OCV_LANGUAGE_DOMAIN)
                    ],
                    'attributes' => [
                        'required' => 'required',
                    ],
                ],
                [
                    'name' => __('Duur van het convenant *', OCV_LANGUAGE_DOMAIN),
                    'id' => 'convenant_Duur_van_het_convenant',
                    'type' => 'text',
                    'attributes' => [
                        'required' => 'required',
                    ],
                ],
                [
                    'name' => __('Datum ondertekening *', OCV_LANGUAGE_DOMAIN),
                    'id' => 'convenant_Datum_ondertekening',
                    'type' => 'text_date',
                    'date_format' => 'd-m-Y',
                    'attributes' => [
                        'required' => 'required',
                    ],
                ],
                [
                    'id' => 'convenant_Bijlagen_bestanden',
                    'type' => 'group',
                    'before_group' => sprintf('<div class="cmb-row"><div class="cmb-th"><label>%s</label></div></div>', __('Bijlagen', OCV_LANGUAGE_DOMAIN)),
                    'clone' => true,
                    'options' => [
                        'group_title' => sprintf('%s %s', __('Bijlage', OCV_LANGUAGE_DOMAIN), '{#}'),
                        'add_button' => __('Voeg bijlage toe', OCV_LANGUAGE_DOMAIN),
                        'remove_button' => __('Verwijder bijlage', OCV_LANGUAGE_DOMAIN),
                        'before' => 'Test',
                    ],
                    'fields' => [
                        [
                            'name' => __('Naam *', OCV_LANGUAGE_DOMAIN),
                            'id' => 'convenant_Bijlagen_Naam',
                            'type' => 'text',
                            'attributes' => [
                                'required' => 'required',
                            ],
                        ],
                        [
                            'name' => __('Bestand *', OCV_LANGUAGE_DOMAIN),
                            'id' => 'convenant_Bijlagen_Bestand',
                            'type' => 'file',
                            'max_file_uploads' => 1,
                            'options' => [
                                'url' => true, // Hide the text input for the url
                            ],
                            'attributes' => [
                                'required' => 'required',
                            ],
                        ]
                    ],
                ],
            ]
        ],
    ],
];
