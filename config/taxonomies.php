<?php declare(strict_types=1);

return [
    'openconvenanten-type' => [
        'object_types' => ['openconvenant-item'],
        'args' => [
            'public' => true,
            'show_in_rest' => true,
            'hierarchical' => false,
            'meta_box_cb' => 'post_categories_meta_box',
            'labels' => [
                'name' => __('Typen', 'openconvenanten'),
                'singular_name' => __('Type', 'openconvenanten'),
                'search_items' => __('Zoek typen', 'openconvenanten'),
                'all_items' => __('Alle typen', 'openconvenanten'),
                'edit_item' => __('Wijzig type', 'openconvenanten'),
                'view_item' => __('Bekijk type', 'openconvenanten'),
                'update_item' => __('Werk type bij', 'openconvenanten'),
                'add_new_item' => __('Voeg type toe', 'openconvenanten'),
                'new_item_name' => __('Nieuwe type naam', 'openconvenanten'),
                'not_found' => __('Geen typen gevonden', 'openconvenanten')
            ]
        ],
    ],
    'openconvenanten-show-on' => [
        'object_types' => ['openconvenant-item'],
        'args' => [
            'public' => true,
            'show_in_rest' => true,
            'hierarchical' => false,
            'meta_box_cb' => 'post_categories_meta_box',
            'labels' => [
                'name' => __('Tonen op', 'openconvenanten'),
                'singular_name' => __('Tonen op', 'openconvenanten'),
                'search_items' => __('Zoek tonen op', 'openconvenanten'),
                'all_items' => __('Alle tonen op', 'openconvenanten'),
                'edit_item' => __('Wijzig tonen op', 'openconvenanten'),
                'view_item' => __('Bekijk tonen op', 'openconvenanten'),
                'update_item' => __('Werk tonen op bij', 'openconvenanten'),
                'add_new_item' => __('Voeg tonen op toe', 'openconvenanten'),
                'new_item_name' => __('Nieuwe tonen op', 'openconvenanten'),
                'not_found' => __('Geen tonen op gevonden', 'openconvenanten')
            ]
        ],
    ],
];
