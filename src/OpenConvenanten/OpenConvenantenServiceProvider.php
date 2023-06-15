<?php

declare(strict_types=1);

namespace Yard\OpenConvenanten;

use WP_Query;
use Yard\OpenConvenanten\Foundation\ServiceProvider;
use Yard\OpenConvenanten\RestAPI\RestAPIServiceProvider;

class OpenConvenantenServiceProvider extends ServiceProvider
{
    const POSTTYPE = 'openconvenant-item';

    /**
     * The array of posttype definitions from the config
     *
     * @var array
     */
    protected $configPostTypes = [];

    public function register()
    {
        $this->plugin->loader->addFilter('wp_insert_post_data', $this, 'fillTitle', 10, 1);
        $this->plugin->loader->addAction('wp_after_insert_post', $this, 'updateSavedPost', 10, 3);
        $this->plugin->loader->addAction('init', $this, 'registerPostTypes');
        $this->plugin->loader->addAction('pre_get_posts', $this, 'orderByPublishedDate');
        (new RestAPIServiceProvider($this->plugin))->register();
    }

    /**
     * Fill the post_title for the overview.
     * Based on post_title update post_name.
     */
    public function fillTitle(array $post = []): array
    {
        if (self::POSTTYPE !== $post['post_type']) {
            return $post;
        }

        $post['post_title'] = isset($_POST['convenant_Onderwerp']) ? \esc_attr($_POST['convenant_Onderwerp']) : $post['post_title'];
        $post['post_name'] = sprintf('openconvenanten-%s', \sanitize_title($post['post_title']));

        return $post;
    }

    /**
     * Fill the post_title for the overview.
     */
    public function updateSavedPost($post, $update, $post_before): void
    {
        if (self::POSTTYPE !== \get_post_type($post)) {
            return;
        }

        $information = \get_post_meta($post, 'convenanten_Convenantverzoek_informatie', true);
        $timestamp = $information['convenant_Tijdstip_laatste_wijziging']['timestamp'] ?? null;

        \update_post_meta($post, 'updated_at', $timestamp);
        if (! \metadata_exists('post', $post, 'convenant_UUID')) {
            \update_post_meta($post, 'convenant_UUID', sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff)|0x4000,
                mt_rand(0, 0x3fff)|0x8000,
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff)
            ));
        }
    }

    /**
     * Add default order.
     *
     * @param WP_Query $query
     *
     * @return void
     */
    public function orderByPublishedDate(WP_Query $query)
    {
        if (! is_admin()) {
            return;
        }

        if (! $query->is_main_query() || self::POSTTYPE != $query->get('post_type')) {
            return;
        }

        if (isset($_GET['orderby'])) {
            return;
        }

        $query->set('orderby', 'post_date');
        $query->set('order', 'DESC');
    }

    /**
     * register custom posttypes.
     */
    public function registerPostTypes(): void
    {
        \register_post_type(self::POSTTYPE, [
            'label' => 'Convenanten',
            'public' => true,
            'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_rest' => true,
            'query_var' => false,
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => ['author', 'excerpt'],
        ]);
    }
}
