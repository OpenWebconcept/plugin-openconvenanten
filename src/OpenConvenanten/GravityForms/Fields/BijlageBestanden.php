<?php

namespace Yard\OpenConvenanten\GravityForms\Fields;

class BijlageBestanden extends Field
{
    public function get(): array
    {
        $this->fieldValue = json_decode($this->fieldValue);

        if (! is_array($this->fieldValue)) {
            return [];
        }

        $entries = array_map(function ($url) {
            if (empty($url)) {
                return null;
            }

            $mediaId = $this->mediaIdFromUrl($url);

            if (! $mediaId) {
                return null;
            }

            return [
                'convenant_Bijlagen_Bestand' => $mediaId,
                'convenant_Bijlagen_Naam'    => get_the_title($mediaId),
                // 'convenant_Bijlagen_URL'     => '',
            ];
        }, $this->fieldValue);

        return array_filter($entries);
    }

    private function mediaIdFromUrl($url): ?int
    {
        $url    = preg_replace('/\/gravity_forms\/[a-z0-9-]+\//', '/', $url);
        $postId = \attachment_url_to_postid($url);

        if (0 !== $postId) {
            return $postId;
        }

        // try again but add -scaled to the end before the extension
        $url    = preg_replace('/(\.[a-z0-9]+)$/', '-scaled$1', $url);
        $postId = \attachment_url_to_postid($url);

        return 0 !== $postId ? $postId : null;
    }
}
