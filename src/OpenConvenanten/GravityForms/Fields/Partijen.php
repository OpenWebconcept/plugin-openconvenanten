<?php

namespace Yard\OpenConvenanten\GravityForms\Fields;

class Partijen extends Field
{
    public function get(): array
    {
        if (empty($this->fieldValue)) {
            return [];
        }

        $exploded = explode(',', $this->fieldValue);

        return array_map(function ($value) {
            return [
                'convenant_Partijen_Naam' => trim($value),
            ];
        }, $exploded);
    }
}
