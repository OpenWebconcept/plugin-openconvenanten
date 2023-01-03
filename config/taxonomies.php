<?php declare(strict_types=1);

return [
    'openconvenanten-type' => [
        'object_types' => ['openconvenant-item'],
        'args'         => [
            'public' => true,
            'show_in_rest' => true,
            'hierarchical' => false,
            'meta_box_cb' => 'post_categories_meta_box',
            'labels' => [
                'name' => __('Types', OCV_LANGUAGE_DOMAIN),
                'singular_name' => __('Type', OCV_LANGUAGE_DOMAIN),
                'search_items' => __('Search types', OCV_LANGUAGE_DOMAIN),
                'all_items' => __('All types', OCV_LANGUAGE_DOMAIN),
                'edit_item' => __('Edit type', OCV_LANGUAGE_DOMAIN),
                'view_item' => __('View type', OCV_LANGUAGE_DOMAIN),
                'update_item' => __('Update type', OCV_LANGUAGE_DOMAIN),
                'add_new_item' => __('Add type', OCV_LANGUAGE_DOMAIN),
                'new_item_name' => __('New type name', OCV_LANGUAGE_DOMAIN),
                'not_found' => __('No types found', OCV_LANGUAGE_DOMAIN)
            ]
        ],
    ],
];
