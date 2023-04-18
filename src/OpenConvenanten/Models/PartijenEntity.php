<?php

declare(strict_types=1);

namespace Yard\OpenConvenanten\Models;

class PartijenEntity extends AbstractEntity
{
    protected array $required = ['Naam'];

    protected function data(): array
    {
        return array_filter(array_map(function ($item) {
            $item = maybe_unserialize($item);

            if (empty($item[$this->getMetaKeyWithPrefix('Partijen_Naam')])) {
                return null;
            }
        
            return [
                'Naam' => $item[$this->getMetaKeyWithPrefix('Partijen_Naam')] ?? '',
            ];
        }, $this->data));
    }
}
