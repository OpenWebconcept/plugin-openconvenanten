<?php

declare(strict_types=1);

namespace Yard\OpenConvenanten\Repository;

use WP_Post;
use WP_Query;

abstract class Base
{
    protected string $posttype;
    protected string $model;

    /**
     * Instance of the WP_Query object.
     *
     * @var null|WP_Query
     */
    protected $query = null;

    /**
     * Arguments for the WP_Query.
     */
    protected array $queryArgs = [];

    /**
     * Get all the items from the database.
     */
    public function all(): array
    {
        $args = array_merge($this->queryArgs, [
            'post_type' => [$this->posttype],
        ]);

        $this->query = new WP_Query($args);

        return array_map([$this, 'transform'], $this->getQuery()->posts);
    }

    /**
     * Get the latest items from the database.
     */
    public function latest(int $limit = 10): array
    {
        $args = array_merge($this->queryArgs, [
            'post_type'      => [$this->posttype],
            'posts_per_page' => $limit,
        ]);

        $this->query = new WP_Query($args);

        return array_map([$this, 'transform'], $this->getQuery()->posts);
    }

    /**
     * Find a particular pdc item by slug.
     */
    public function findBySlug(string $slug): array
    {
        $args = array_merge($this->queryArgs, [
            'post_type'       => [$this->posttype],
            'name'            => sprintf('openconvenanten-%s', $slug),
        ]);

        $this->query = new WP_Query($args);

        if (empty($this->getQuery()->posts)) {
            return [];
        }

        return $this->transform(reset($this->getQuery()->posts));
    }

    /**
     * Get the WP_Query object.
     */
    public function getQuery(): WP_Query
    {
        return $this->query;
    }

    /**
     * Add additional query arguments.
     */
    public function query(array $args): self
    {
        $this->queryArgs = array_merge($this->queryArgs, $args);

        return $this;
    }

    /**
     * Returns the query args.
     */
    public function getQueryArgs(): array
    {
        return $this->queryArgs;
    }

    /**
     * Transform a single WP_Post item.
     */
    public function transform(WP_Post $post): array
    {
        if (\property_exists(\get_called_class(), 'model')) {
            $model = $this->getModel();

            return (new $model($post->to_array()))->transform();
        }

        $data = [
            'id'      => $post->ID,
            'title'   => $post->post_title,
            'content' => apply_filters('the_content', $post->post_content),
            'excerpt' => $post->post_excerpt,
            'date'    => $post->post_date,
        ];

        return $data;
    }

    /**
     * Get the value of model
     */
    public function getModel()
    {
        return $this->model;
    }
}
