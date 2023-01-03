<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\Tests\Models;

use Mockery as m;
use WP_Mock;
use Yard\OpenConvenanten\ElasticPress\ElasticPress;
use Yard\OpenConvenanten\Foundation\Config;
use Yard\OpenConvenanten\Foundation\Loader;
use Yard\OpenConvenanten\Foundation\Plugin;
use Yard\OpenConvenanten\Models\Item;
use Yard\OpenConvenanten\Models\OpenConvenanten;
use Yard\OpenConvenanten\Repository\OpenConvenantenRepository;
use Yard\OpenConvenanten\Tests\TestCase;

class OpenConvenantenTest extends TestCase
{
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
    public function if_class_is_instance_of_OpenConvenanten_class()
    {
        \WP_Mock::userFunction('get_post_meta', [
            'times'  => 1,
            'return' => [],
        ]);

        $openconvenanten = new OpenConvenanten([
            'ID' => 1
        ]);
        $this->assertInstanceOf(OpenConvenanten::class, $openconvenanten);
    }
}
