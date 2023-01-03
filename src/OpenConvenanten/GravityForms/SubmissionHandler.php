<?php

namespace Yard\OpenConvenanten\GravityForms;

use Yard\OpenConvenanten\GravityForms\Fields\BijlageBestanden;
use Yard\OpenConvenanten\GravityForms\Fields\BijlageURLS;
use Yard\OpenConvenanten\GravityForms\Fields\Partijen;
use Yard\OpenConvenanten\GravityForms\Fields\Title;

class SubmissionHandler
{
    public function transform(int $ID, array $feed, array $entry, array $form): void
    {
        if (! $this->isOpenConvenantForm($form)) {
            return;
        }
        $metaFields  = rgars($feed, 'meta/postMetaFields');

        $attachments = $this->getAttachments($metaFields, $entry);
        $parties     = $this->getParties($metaFields, $entry);

        $this->updatePostMeta($ID, array_merge($attachments, $parties));
        $this->updatePostTitle($ID, $metaFields, $entry);
    }

    private function getAttachments(array $metadata, array $entry): array
    {
        return [
            'convenant_Bijlagen' => array_merge(
                BijlageURLS::make('convenant_BijlageURLS', $metadata, $entry)->get(),
                BijlageBestanden::make('convenant_BijlageBestanden', $metadata, $entry)->get()
            ),
        ];
    }

    private function getParties(array $metadata, array $entry): array
    {
        $key = 'convenant_Partijen';

        return [
            $key => Partijen::make($key, $metadata, $entry)->get(),
        ];
    }

    private function updatePostMeta(int $ID, array $meta): void
    {
        foreach ($meta as $key => $value) {
            delete_post_meta($ID, $key);
        }

        foreach ($meta as $key => $value) {
            if (! is_array($value)) {
                add_post_meta($ID, $key, $value);

                continue;
            }

            foreach ($value as $subValue) {
                add_post_meta($ID, $key, $subValue);
            }
        }
    }

    private function updatePostTitle(int $ID, array $metadata, array $entry): void
    {
        wp_update_post([
            'ID'         => $ID,
            'post_title' => Title::make('convenant_ID', $metadata, $entry)->get(),
        ]);
    }

    private function isOpenConvenantForm($form): bool
    {
        return strpos($form['title'], 'OpenConvenant') !== false;
    }
}
