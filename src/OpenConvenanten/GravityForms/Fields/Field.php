<?php

namespace Yard\OpenConvenanten\GravityForms\Fields;

abstract class Field
{
    protected string $key;
    protected array $metadata;
    protected array $entry;
    protected $fieldValue;

    public function __construct(string $key, array $metadata, array $entry)
    {
        $this->key        = $key;
        $this->metadata   = $metadata;
        $this->entry      = $entry;
        $this->fieldValue = $this->value($key);
    }

    public static function make(string $key, array $metadata, array $entry)
    {
        return new static($key, $metadata, $entry);
    }

    /**
     * @return mixed
     */
    protected function value(string $key)
    {
        $metaField = $this->getMetaField($this->key);
        
        if (! empty($metaField['value'])) {
            return null;
        }
        
        return $this->entry[$metaField['value']] ?? null;
    }
    
    protected function getMetaField(string $key): ?array
    {
        foreach ($this->metadata as $metaField) {
            if ($metaField['custom_key'] === $key || $metaField['key'] === $key) {
                return $metaField;
            }
        }
        
        return null;
    }

    /**
     * @return mixed
     */
    abstract public function get();
}
