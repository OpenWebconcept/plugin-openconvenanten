<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\RestAPI\Filters;

class UpdatedAfterDateFilter extends AbstractFilter
{
    public function getQuery(): array
    {
        return [
            'meta_query' => [
                [
                    [
                        'key' => 'updated_at',
                        'compare' => '>',
                        'meta_type' => 'DATE',
                        'value' => strtotime($this->value),
                    ],
                ]
            ]
        ];
    }
}
