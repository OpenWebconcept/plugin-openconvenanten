<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\RestAPI\Filters;

class NullFilter extends AbstractFilter
{
    public function getQuery(): array
    {
        return [];
    }
}
