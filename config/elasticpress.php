<?php declare(strict_types=1);

return [
    'indexables' => [
        'openconvenant-item'
    ],
    'postStatus' => [
        'publish'
    ],
    'language'   => 'dutch',
    'expire'     => [
        'offset' => '14d',
        'decay'  => 0.5,
    ],
    'search' => [
        'weight' => 2
    ],
    'mapping' => [
        'file' => OCV_ROOT_PATH . '/src/OpenConvenanten/ElasticPress/mappings/7-0.php'
    ]
];
