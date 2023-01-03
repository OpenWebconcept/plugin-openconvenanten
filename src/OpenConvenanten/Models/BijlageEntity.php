<?php

declare(strict_types=1);

namespace Yard\OpenConvenanten\Models;

class BijlageEntity extends AbstractEntity
{
    /** @var array */
    protected $required = ['URL_Bijlage', 'Naam_Bijlage'];

    protected function data(): array
    {
        if (! empty($this->data[self::PREFIX . 'Bijlagen_Bestand']) && is_array($this->data[self::PREFIX . 'Bijlagen_Bestand'])) {
            return [
                'URL_Bijlage'  => \wp_get_attachment_url($this->data[self::PREFIX . 'Bijlagen_Bestand'][0]),
                'Naam_Bijlage' => $this->data[self::PREFIX . 'Bijlagen_Naam'],
            ];
        }

        if (! empty($this->data[self::PREFIX . 'Bijlagen_URL'])) {
            return [
                'URL_Bijlage'  => $this->data[self::PREFIX . 'Bijlagen_URL'],
                'Naam_Bijlage' => $this->data[self::PREFIX . 'Bijlagen_Naam'],
            ];
        }

        return [];
    }
}
