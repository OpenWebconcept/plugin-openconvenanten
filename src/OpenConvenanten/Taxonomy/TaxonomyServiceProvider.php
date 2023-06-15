<?php

declare(strict_types=1);

namespace Yard\OpenConvenanten\Taxonomy;

use Yard\OpenConvenanten\Foundation\ServiceProvider;

class TaxonomyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->plugin->loader->addAction('init', $this, 'registerTaxonomies');
        $this->plugin->loader->addAction('openconvenanten-show-on_add_form_fields', TaxonomyController::class, 'addShowOnExplanation');
    }

    public function registerTaxonomies(): void
    {
        $taxonomies = $this->plugin->config->get('taxonomies') ?? [];

        if (empty($taxonomies)) {
            return;
        }

        foreach ($taxonomies as $taxonomyName => $taxonomy) {
            \register_taxonomy($taxonomyName, $taxonomy['object_types'], $taxonomy['args']);
        }
    }
}
