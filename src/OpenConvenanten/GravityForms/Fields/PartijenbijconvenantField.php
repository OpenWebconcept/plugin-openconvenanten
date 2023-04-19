<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\GravityForms\Fields;

class PartijenbijconvenantField extends Field
{
    public function get(): array
    {
        $unserialized = maybe_unserialize($this->value);

        if (! $unserialized) {
            return [];
        }

        return array_map(function ($value) {
            return [
                'convenant_Partijen_Naam' => trim($value),
            ];
        }, $unserialized);
    }
}
