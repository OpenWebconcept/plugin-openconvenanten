<?php

declare(strict_types=1);

namespace Yard\OpenConvenanten\RestAPI;

use Yard\OpenConvenanten\Foundation\ServiceProvider;

/**
 *  @OA\Server(
 *    url="https://{site}/wp-json/yard/openconvenanten/v1",
 *    description=""
 *  ),
 *  @OA\Info(
 *    title="OpenWebConcept OpenConvenanten API",
 *    version="1.0.13",
 *    termsOfService="https://www.openwebconcept.nl/",
 *    @OA\Contact(
 *      name="OpenWebConcept",
 *      url="https://www.openwebconcept.nl/",
 *      email="info@openwebconcept.nl"
 *    ),
 *    x={
 *      "logo": {
 *         "url": "https://openwebconcept.nl/wp-content/themes/openwebconcept/assets/src/images/logo-dark.png"
 *      },
 *      "description": {
 *         "$ref"="../chapters/description.md"
 *      },
 *      "externalDocs": {
 *         "description": "Find out how to create Github repo for your OpenAPI spec.",
 *         "url": "https://openwebconcept.bitbucket.io/openconvenanten/"
 *       }
 *    },
 *    @OA\License(
 *      name="OpenWebConcept",
 *      url="https://www.openwebconcept.nl/"
 *    )
 * )
 */
class RestAPIServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    private $namespace = 'owc/openconvenanten/v1';

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->plugin->loader->addFilter('rest_api_init', $this, 'registerRoutes');
        $this->plugin->loader->addFilter('owc/config-expander/rest-api/whitelist', $this, 'whitelist', 10, 1);

        $this->registerModelFields();
    }

    /**
     * Register routes on the rest API.
     *
     * @return void
     */
    public function registerRoutes()
    {
        \register_rest_route($this->namespace, 'items', [
            'methods'             => \WP_REST_Server::READABLE,
            'callback'            => [new ItemController($this->plugin), 'getItems'],
            'permission_callback' => '__return_true',
        ]);

        \register_rest_route($this->namespace, 'items/latest', [
            'methods'             => \WP_REST_Server::READABLE,
            'callback'            => [new ItemController($this->plugin), 'getLatestItems'],
            'permission_callback' => '__return_true',
        ]);

        \register_rest_route($this->namespace, 'items/(?P<slug>[a-zA-Z0-9-]+)', [
            'methods'             => \WP_REST_Server::READABLE,
            'callback'            => [new ItemController($this->plugin), 'getItem'],
            'permission_callback' => '__return_true',
        ]);
    }

    /**
     * Whitelist endpoints within Config Expander.
     *
     * @param array $whitelist
     *
     * @return array
     */
    public function whitelist(array $whitelist): array
    {
        // Remove default root endpoint
        unset($whitelist['wp/v2']);

        $whitelist[$this->namespace] = [
            'endpoint_stub' => '/' . $this->namespace,
            'methods'       => ['GET'],
        ];

        return $whitelist;
    }

    /**
     * Register fields for all configured posttypes.
     *
     * @return void
     */
    private function registerModelFields(): void
    {
        // Add global fields for all Models.
        foreach ($this->plugin->config->get('api.models') as $posttype => $data) {
            foreach ($data['fields'] as $key => $creator) {
                $class = '\Yard\OpenConvenanten\Models\\' . ucfirst($posttype);
                if (class_exists($class)) {
                    $class::addGlobalField($key, new $creator($this->plugin));
                }
            }
        }
    }
}
