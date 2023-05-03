<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\RestAPI\Filters;

class PublishedAfterDateFilter extends AbstractFilter
{
    public function getQuery(): array
    {
        return [
            'date_query' => [
                'column' => 'post_date',
                'after' => $this->value
            ]
        ];
    }
}
