<?php declare(strict_types=1);

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
                'convenant_Bijlagen_Bestand' => $attachmentURL
            ];
        }, $attachmentsArray);

        return array_filter($mapped);
    }
}
