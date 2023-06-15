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
                'name' => __('Typen', OCV_LANGUAGE_DOMAIN),
                'singular_name' => __('Type', OCV_LANGUAGE_DOMAIN),
                'search_items' => __('Zoek typen', OCV_LANGUAGE_DOMAIN),
                'all_items' => __('Alle typen', OCV_LANGUAGE_DOMAIN),
                'edit_item' => __('Wijzig type', OCV_LANGUAGE_DOMAIN),
                'view_item' => __('Bekijk type', OCV_LANGUAGE_DOMAIN),
                'update_item' => __('Werk type bij', OCV_LANGUAGE_DOMAIN),
                'add_new_item' => __('Voeg type toe', OCV_LANGUAGE_DOMAIN),
                'new_item_name' => __('Nieuwe type naam', OCV_LANGUAGE_DOMAIN),
                'not_found' => __('Geen typen gevonden', OCV_LANGUAGE_DOMAIN)
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
                'name' => __('Tonen op', OCV_LANGUAGE_DOMAIN),
                'singular_name' => __('Tonen op', OCV_LANGUAGE_DOMAIN),
                'search_items' => __('Zoek tonen op', OCV_LANGUAGE_DOMAIN),
                'all_items' => __('Alle tonen op', OCV_LANGUAGE_DOMAIN),
                'edit_item' => __('Wijzig tonen op', OCV_LANGUAGE_DOMAIN),
                'view_item' => __('Bekijk tonen op', OCV_LANGUAGE_DOMAIN),
                'update_item' => __('Werk tonen op bij', OCV_LANGUAGE_DOMAIN),
                'add_new_item' => __('Voeg tonen op toe', OCV_LANGUAGE_DOMAIN),
                'new_item_name' => __('Nieuwe tonen op', OCV_LANGUAGE_DOMAIN),
                'not_found' => __('Geen tonen op gevonden', OCV_LANGUAGE_DOMAIN)
            ]
        ],
    ],
];
