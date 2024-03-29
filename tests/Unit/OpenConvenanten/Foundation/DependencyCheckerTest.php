<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\Tests\Foundation;

use Mockery as m;
use WP_Mock;
use Yard\OpenConvenanten\Foundation\DependencyChecker;
use Yard\OpenConvenanten\Foundation\DismissableAdminNotice;
use Yard\OpenConvenanten\Tests\TestCase;

class DependencyCheckerTest extends TestCase
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
    public function it_fails_when_plugin_is_inactive()
    {
        $dependencies = [
            [
                'type' => 'plugin',
                'label' => 'Dependency #1',
                'file' => 'test-plugin/test-plugin.php'
            ]
        ];

        $dismissableAdminNotice = m::mock(DismissableAdminNotice::class);
        $checker = new DependencyChecker($dependencies, [], $dismissableAdminNotice);

        WP_Mock::userFunction('is_plugin_active')
            ->withArgs(['test-plugin/test-plugin.php'])
            ->once()
            ->andReturn(false);

        $this->assertTrue($checker->hasFailures());
    }

    /** @test */
    public function it_succeeds_when_no_dependencies_are_set()
    {
        $dismissableAdminNotice = m::mock(DismissableAdminNotice::class);
        $checker = new DependencyChecker([], [], $dismissableAdminNotice);

        WP_Mock::userFunction('is_plugin_active')
            ->never();

        $this->assertFalse($checker->hasFailures());
    }

    /**
     * @dataProvider wrongVersions
     *
     * @test
     */
    public function it_fails_when_plugin_is_active_but_versions_mismatch($version)
    {
        $dependencies = [
            [
                'type' => 'plugin',
                'label' => 'Dependency #1',
                'file' => 'pluginstub.php', // tests/Unit/pluginstub.php
                'version' => $version // Version in pluginstub.php is 1.1.7
            ]
        ];

        $dismissableAdminNotice = m::mock(DismissableAdminNotice::class);
        $checker = new DependencyChecker($dependencies, [], $dismissableAdminNotice);

        WP_Mock::userFunction('is_plugin_active')
            ->withArgs(['pluginstub.php'])
            ->once()
            ->andReturn(true);

        $this->assertTrue($checker->hasFailures());
    }

    /**
     * @dataProvider correctVersions
     *
     * @test
     */
    public function it_succeeds_when_plugin_is_active_and_versions_match($version)
    {
        $dependencies = [
            [
                'type' => 'plugin',
                'label' => 'Dependency #1',
                'file' => 'pluginstub.php', // tests/Unit/pluginstub.php
                'version' => $version // Version in pluginstub.php is 1.1.7
            ]
        ];

        $dismissableAdminNotice = m::mock(DismissableAdminNotice::class);
        $checker = new DependencyChecker($dependencies, [], $dismissableAdminNotice);

        WP_Mock::userFunction('is_plugin_active')
            ->withArgs(['pluginstub.php'])
            ->once()
            ->andReturn(true);

        $this->assertFalse($checker->hasFailures());
    }

    /**
     * Provides old version numbers.
     * Version in pluginstub.php is 1.1.7
     *
     * @return array
     */
    public function wrongVersions()
    {
        return [
            ['1.1.8'],
            ['2.0'],
            ['3']
        ];
    }

    public function correctVersions()
    {
        return [
            ['1.1.2'],
            ['1.0'],
            ['1']
        ];
    }
}
