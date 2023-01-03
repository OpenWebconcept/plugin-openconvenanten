<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\Tests\ElasticPress;

use Mockery as m;
use WP_Mock;
use Yard\OpenConvenanten\ElasticPress\ElasticPress;
use Yard\OpenConvenanten\Foundation\Config;
use Yard\OpenConvenanten\Foundation\Loader;
use Yard\OpenConvenanten\Foundation\Plugin;
use Yard\OpenConvenanten\Models\Item;
use Yard\OpenConvenanten\Repository\OpenConvenantenRepository;
use Yard\OpenConvenanten\Tests\TestCase;

class ElasticPressTest extends TestCase
{

    /**
     * @var ElasticPress
     */
    protected $service;

    /**
     * @var
     */
    protected $config;

    /**
     * @var
     */
    protected $plugin;

    protected function setUp(): void
    {
        WP_Mock::setUp();

        $this->config = m::mock(Config::class);
        $this->repository = m::mock(OpenConvenantenRepository::class);

        $this->plugin = m::mock(Plugin::class);
        $this->plugin->config = $this->config;
        $this->plugin->loader = m::mock(Loader::class);

        $this->item = m::mock(Item::class);

        $this->service = new ElasticPress($this->config, $this->repository);
    }

    protected function tearDown(): void
    {
        WP_Mock::tearDown();
    }

    /** @test */
    public function it_sets_the_language_from_the_config()
    {
        WP_Mock::expectFilterAdded('ep_analyzer_language', [$this->service, 'setLanguage'], 10, 2);

        $this->plugin->config->shouldReceive('get')->with('elasticpress.language')->andReturn('dutch');

        $this->service->setLanguage('dutch', '');

        $this->service->setFilters();

        $this->assertTrue(true);
    }

    /** @test */
    public function test_get_settings()
    {
        \WP_Mock::userFunction('get_option', [
            'times'  => 1,
            'return' => [],
        ]);

        $expected = [];
        $actual = $this->service->getSettings();

        $this->assertEquals($expected, $actual);
    }
}
