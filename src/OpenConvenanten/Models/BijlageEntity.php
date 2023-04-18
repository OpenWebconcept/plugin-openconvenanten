<?php

declare(strict_types=1);

namespace Yard\OpenConvenanten\Models;

class BijlageEntity extends AbstractEntity
{
    protected array $required = ['URL_Bijlage', 'Naam_Bijlage'];

    protected function data(): array
    {
        if (! empty($this->data[$this->getMetaKeyWithPrefix('Bijlagen_Bestand')]) && is_array($this->data[$this->getMetaKeyWithPrefix('Bijlagen_Bestand')])) {
            return [
                'URL_Bijlage'  => \wp_get_attachment_url($this->data[$this->getMetaKeyWithPrefix('Bijlagen_Bestand')][0] ?? 0),
                'Naam_Bijlage' => $this->data[$this->getMetaKeyWithPrefix('Bijlagen_Naam')] ?? '',
            ];
        }

        if (! empty($this->data[$this->getMetaKeyWithPrefix('Bijlagen_URL')])) {
            return [
                'URL_Bijlage'  => $this->data[$this->getMetaKeyWithPrefix('Bijlagen_URL')] ?? '',
                'Naam_Bijlage' => $this->data[$this->getMetaKeyWithPrefix('Bijlagen_Naam')] ?? '',
            ];
        }

        return [];
    }
}
