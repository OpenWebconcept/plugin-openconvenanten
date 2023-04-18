<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\Metabox;

use Yard\OpenConvenanten\Foundation\ServiceProvider;

class MetaboxServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->plugin->loader->addFilter('rwmb_meta_boxes', $this, 'registerMetaboxes', 10, 1);
    }

    /**
     * Register metaboxes.
     */
    public function registerMetaboxes(array $rwmbMetaboxes): array
    {
        $metaboxes = $this->plugin->config->get('metaboxes') ?? [];

        return array_merge($rwmbMetaboxes, \apply_filters('yard/openconvenanten/before-register-metaboxes', $metaboxes));
    }
}
