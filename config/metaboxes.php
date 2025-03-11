<?php

declare(strict_types=1);

return [
    'convenanten_base' => [
        'id' => 'openconvenanten_metadata',
        'title' => __('Data', 'openconvenanten'),
        'object_types' => ['openconvenant-item'],
        'context' => 'normal',
        'priority' => 'high',
        'autosave' => true,
        'fields' => [
            'general' => [
                [
                    'name' => __('Zaaknummer (ID) *', 'openconvenanten'),
                    'id' => 'convenant_Zaaknummer_ID',
                    'type' => 'text',
                    'attributes' => [
                        'required' => 'required',
                    ],
                ],
                [
                    'name' => __('Onderwerp *', 'openconvenanten'),
                    'id' => 'convenant_Onderwerp',
                    'type' => 'text',
                    'attributes' => [
                        'required' => 'required',
                    ],
                ],
                [
                    'name' => __('Samenvatting *', 'openconvenanten'),
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
                    'before_group' => sprintf('<div class="cmb-row"><div class="cmb-th"><label>%s</label></div></div>', __('Partijen bij convenant', 'openconvenanten')),
                    'clone' => true,
                    'options' => [
                        'group_title' => sprintf('%s %s', __('Partij', 'openconvenanten'), '{#}'),
                        'add_button' => __('Voeg partij toe', 'openconvenanten'),
                        'remove_button' => __('Verwijder partij', 'openconvenanten')
                    ],
                    'fields' => [
                        [
                            'name' => __('Naam *', 'openconvenanten'),
                            'id' => 'convenant_Partijen_Naam',
                            'type' => 'text',
                            'attributes' => [
                                'required' => 'required',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => __('Beleidsterrein *', 'openconvenanten'),
                    'id' => 'convenant_Beleidsterrein',
                    'type' => 'select',
                    'options' => [
                        'Economie' => __('Economie', 'openconvenanten'),
                        'Onderwijs' => __('Onderwijs', 'openconvenanten'),
                        'Wonen' => __('Wonen', 'openconvenanten'),
                        'Zorg' => __('Zorg', 'openconvenanten'),
                        'Veiligheid' => __('Veiligheid', 'openconvenanten'),
                        'Ruimte' => __('Ruimte', 'openconvenanten'),
                        'Cultuur' => __('Cultuur', 'openconvenanten'),
                        'Sport' => __('Sport', 'openconvenanten'),
                        'Milieu' => __('Milieu', 'openconvenanten'),
                        'Overig' => __('Overig', 'openconvenanten')
                    ],
                    'attributes' => [
                        'required' => 'required',
                    ],
                ],
                [
                    'name' => __('Duur van het convenant *', 'openconvenanten'),
                    'id' => 'convenant_Duur_van_het_convenant',
                    'type' => 'text',
                    'attributes' => [
                        'required' => 'required',
                    ],
                ],
                [
                    'name' => __('Datum ondertekening *', 'openconvenanten'),
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
                    'before_group' => sprintf('<div class="cmb-row"><div class="cmb-th"><label>%s</label></div></div>', __('Bijlagen', 'openconvenanten')),
                    'clone' => true,
                    'options' => [
                        'group_title' => sprintf('%s %s', __('Bijlage', 'openconvenanten'), '{#}'),
                        'add_button' => __('Voeg bijlage toe', 'openconvenanten'),
                        'remove_button' => __('Verwijder bijlage', 'openconvenanten'),
                        'before' => 'Test',
                    ],
                    'fields' => [
                        [
                            'name' => __('Naam *', 'openconvenanten'),
                            'id' => 'convenant_Bijlagen_Naam',
                            'type' => 'text',
                            'attributes' => [
                                'required' => 'required',
                            ],
                        ],
                        [
                            'name' => __('Bestand *', 'openconvenanten'),
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
