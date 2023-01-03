<?php

namespace Yard\OpenConvenanten\GravityForms\Fields;

class Title extends Field
{
    public function get(): string
    {
        return sprintf('OpenConvenanten: %s', $this->fieldValue);
    }
}
