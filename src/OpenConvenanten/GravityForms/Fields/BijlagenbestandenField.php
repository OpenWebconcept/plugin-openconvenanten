<?php

namespace Yard\OpenConvenanten\GravityForms\Fields;

use Yard\OpenConvenanten\Traits\GravityFormsUploadToMediaLibrary;

class BijlagenbestandenField extends Field
{
    use GravityFormsUploadToMediaLibrary;
    
    public function get(): array
    {
        $attachmentsArray = json_decode($this->value);

        if (! is_array($attachmentsArray)) {
            return [];
        }
        
        $mapped = array_map(function ($attachmentURL) {
            $attachmentID = $this->gravityFormsUploadToMediaLibrary($attachmentURL);
            $attachmentURL = \wp_get_attachment_url($attachmentID);

            if (! $attachmentID || ! $attachmentURL) {
                return [];
            }

            return [
                'convenant_Bijlagen_Naam' => basename($attachmentURL),
                'convenant_Bijlagen_Bestand' => $attachmentID
            ];
        }, $attachmentsArray);

        return array_filter($mapped);
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
