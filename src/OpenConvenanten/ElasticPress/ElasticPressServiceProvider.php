<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\ElasticPress;

use ElasticPress\Indexables;
use Yard\OpenConvenanten\Foundation\ServiceProvider;
use Yard\OpenConvenanten\Repository\OpenConvenantenRepository;

class ElasticPressServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @throws Exception
     */
    public function register()
    {
        if (\is_plugin_active('yard-elasticsearch/yard-elasticsearch.php')) {
            return;
        }

        if (! class_exists('\ElasticPress\Elasticsearch')) {
            return;
        }

        Indexables::factory()->register(new OpenConvenantenIndexable(new OpenConvenantenRepository, $this->plugin->config));

        add_filter('ep_dashboard_indexable_labels', function ($labels) {
            $labels['openwoo'] = [
                'singular' => esc_html__('openconvenant-item', 'elasticpress'),
                'plural' => esc_html__('openconvenanten', 'elasticpress'),
            ];

            return $labels;
        });

        $elasticPress = new ElasticPress($this->plugin->config, new OpenConvenantenRepository);
        $this->plugin->loader->addAction('init', $elasticPress, 'setSettings', 10, 1);
        $this->plugin->loader->addAction('init', $elasticPress, 'setFilters', 10, 1);
    }
}
