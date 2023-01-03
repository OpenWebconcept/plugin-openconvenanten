<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\Metabox;

use Mockery as m;
use WP_Mock;
use Yard\OpenConvenanten\Foundation\Config;
use Yard\OpenConvenanten\Foundation\Loader;
use Yard\OpenConvenanten\Foundation\Plugin;
use Yard\OpenConvenanten\Tests\TestCase;

class MetaboxServiceProviderTest extends TestCase
{
    protected function setUp(): void
    {
        WP_Mock::setUp();
    }

    protected function tearDown(): void
    {
        WP_Mock::tearDown();
    }

    /** @test */
    public function check_registration_of_metaboxes()
    {
        $config = m::mock(Config::class);
        $plugin = m::mock(Plugin::class);

        $plugin->config = $config;
        $plugin->loader = m::mock(Loader::class);

        $service = new MetaboxServiceProvider($plugin);

        $plugin->loader->shouldReceive('addFilter')->withArgs([
            'rwmb_meta_boxes',
            $service,
            'registerMetaboxes',
            10,
            1
        ])->once();

        $service->register();

        $configMetaboxes = [
            'base' => [
                'id'     => 'metadata',
                'fields' => [
                    'general' => [
                        'testfield_noid' => [
                            'type' => 'heading'
                        ],
                        'testfield1'     => [
                            'id' => 'metabox_id1'
                        ],
                        'testfield2'     => [
                            'id' => 'metabox_id2'
                        ]
                    ]
                ]
            ]
        ];

        $prefix = MetaboxServiceProvider::PREFIX;

        $expectedMetaboxes = [
            0 => [
                'id'     => 'metadata',
                'fields' => [
                    [
                        'type' => 'heading'
                    ],
                    [
                        'id' => $prefix . 'metabox_id1'
                    ],
                    [
                        'id' => $prefix . 'metabox_id2'
                    ]
                ]
            ]
        ];

        $config->shouldReceive('get')->with('metaboxes')->once()->andReturn($configMetaboxes);

        //test for filter being called
        \WP_Mock::expectFilter('yard/openconvenanten/before-register-metaboxes', $expectedMetaboxes);

        $this->assertEquals($expectedMetaboxes, $service->registerMetaboxes([]));

        $existingMetaboxes = [
            0 => [
                'id'     => 'existing_metadata',
                'fields' => [
                    [
                        'type' => 'existing_heading'
                    ],
                    [
                        'id' => $prefix . 'existing_metabox_id1'
                    ],
                    [
                        'id' => $prefix . 'existing_metabox_id2'
                    ]
                ]
            ]
        ];

        $expectedMetaboxesAfterMerge = [

            0 => [
                'id'     => 'existing_metadata',
                'fields' => [
                    [
                        'type' => 'existing_heading'
                    ],
                    [
                        'id' => $prefix . 'existing_metabox_id1'
                    ],
                    [
                        'id' => $prefix . 'existing_metabox_id2'
                    ]
                ]
            ],
            1 => [
                'id'     => 'metadata',
                'fields' => [
                    [
                        'type' => 'heading'
                    ],
                    [
                        'id' => $prefix . 'metabox_id1'
                    ],
                    [
                        'id' => $prefix . 'metabox_id2'
                    ]
                ]
            ]
        ];

        $config->shouldReceive('get')->with('metaboxes')->once()->andReturn($configMetaboxes);

        $this->assertEquals($expectedMetaboxesAfterMerge, $service->registerMetaboxes($existingMetaboxes));
    }
}
