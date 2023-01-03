<?php

namespace Yard\OpenConvenanten\GravityForms\Fields;

class BijlageURLS extends Field
{
    public function get(): array
    {
        if (! is_array($this->fieldValue)) {
            return [];
        }

        $formatted = array_map(function ($urlEntry) {
            $url = reset($urlEntry);

            if (! $url) {
                return null;
            }

            return [
                'convenant_Bijlagen_URL'  => $url,
                'convenant_Bijlagen_Naam' => $url,
            ];
        }, $this->fieldValue);

        return array_filter($formatted);
    }
}
