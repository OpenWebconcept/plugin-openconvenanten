<?php

declare(strict_types=1);

namespace Yard\OpenConvenanten\Models;

abstract class AbstractEntity
{
    const PREFIX = 'convenant_';

    /** @var array */
    protected $data = [];

    /** @var array */
    protected $required = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public static function make(array $data = []): self
    {
        return new static($data);
    }

    abstract protected function data();

    public function getRequired(): array
    {
        return $this->required;
    }

    public function get(): array
    {
        $data = array_filter($this->data());

        $dataWithOutRequired = array_filter($data, function ($item, $key) {
            return in_array($key, $this->getRequired());
        }, \ARRAY_FILTER_USE_BOTH);

        if (empty($dataWithOutRequired)) {
            return [];
        }

        return $data;
    }
}
