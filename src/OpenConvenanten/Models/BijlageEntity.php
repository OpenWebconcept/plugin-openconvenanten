<?php

declare(strict_types=1);

namespace Yard\OpenConvenanten\Models;

class BijlageEntity extends AbstractEntity
{
    protected array $required = ['URL_Bijlage', 'Naam_Bijlage'];

    protected function data(): array
    {
        if (! empty($this->getFromData('Bijlagen_Bestand', ''))) {
            return [
                'URL_Bijlage' => $this->getFromData('Bijlagen_Bestand', ''),
                'Naam_Bijlage' => $this->getFromData('Bijlagen_Naam', ''),
            ];
        }

        if (! empty($this->getFromData('Bijlagen_URL'))) {
            return [
                'URL_Bijlage' => $this->getFromData('Bijlagen_URL', ''),
                'Naam_Bijlage' => $this->getFromData('Bijlagen_Naam', ''),
            ];
        }

        return [];
    }
}
