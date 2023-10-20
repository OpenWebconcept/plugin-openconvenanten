<?php

declare(strict_types=1);

namespace Yard\OpenConvenanten\GravityForms;

use WP_Term;

class PostBuilder
{
    private array $formValues = [];

    public function __construct(array $formValues)
    {
        $this->formValues = $formValues;
    }

    public static function make(array $formValues): self
    {
        return new static($formValues);
    }

    public function save(): int
    {
        $postId = $this->insertPost();

        if (0 === $postId) {
            return 0;
        }

        $this->saveMeta($postId, $this->getMetaValues());

        return $postId;
    }

    protected function insertPost(): int
    {
        $data = [
            'post_title' => $this->formValues['Onderwerp'],
            'post_excerpt' => $this->formValues['Samenvatting'],
            'post_content' => '',
            'post_status' => $this->getPostStatus(),
            'post_type' => 'openconvenant-item',
        ];

        return \wp_insert_post($data);
    }

    /**
     * Allow the status to be filtered, accepts only 'draft' and 'publish'.
     * Default post status is 'draft'.
     */
    protected function getPostStatus(): string
    {
        $postStatus = \apply_filters('yard/openconvenanten/insert-post-status', 'draft');
        $allowedStatusses = ['draft', 'publish'];

        return in_array($postStatus, $allowedStatusses) ? $postStatus : 'draft';
    }

    protected function getMetaValues(): array
    {
        return MetaBuilder::make($this->formValues)->get();
    }

    protected function saveMeta(int $postId, array $metaValues): void
    {
        foreach ($metaValues as $key => $value) {
            if ($key === 'convenant_Website') {
                $this->handleShowOnTax($postId, $value);

                continue;
            }

            \update_post_meta($postId, $key, $value);
        }
    }

    private function handleShowOnTax(int $postId, string $value = ''): void
    {
        if (empty($value)) {
            return;
        }

        $terms = \get_terms([
            'taxonomy' => 'openconvenanten-show-on',
            'hide_empty' => false,
        ]);

        if (! is_array($terms)) {
            return;
        }

        $filtered = array_filter($terms, function ($term) use ($value) {
            return $term->slug === $value;
        });

        $termToSet = reset($filtered);

        if (! $termToSet instanceof WP_Term) {
            return;
        }

        \wp_set_post_terms($postId, [$termToSet->term_id], 'openconvenanten-show-on', true);
    }
}
