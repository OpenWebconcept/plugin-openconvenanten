<?php

declare(strict_types=1);

namespace Yard\OpenConvenanten\Models;

use WP_Post;

/**
 * @OA\Schema(
 *   title="OpenConvenanten model",
 *   type="object"
 * )
 */
class OpenConvenanten
{
    /**
     * @var array
     */
    protected $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $this->cleanupData($data);
    }

    protected function cleanupData(array $data): array
    {
        $data['meta'] = array_filter(\get_post_meta($data['ID']), function ($key) {
            return ! preg_match('/^_(.+)/', $key);
        }, ARRAY_FILTER_USE_KEY);

        $data['meta'] = array_map(function ($item) {
            if (is_array($item) and (1 === count($item))) {
                return \maybe_unserialize($item[0]);
            }

            return \maybe_unserialize($item);
        }, $data['meta']);

        return $data;
    }

    /**
     * Transform a single WP_Post item.
     */
    public function transform(): array
    {
        $data = [
            'Convenantverzoek_informatie' => InfoEntity::make($this->meta('Convenantverzoek_informatie', []))->get(),
            'ID'                          => $this->meta('ID'),
            'Titel'                       => $this->meta('Titel', $this->meta('ID')),
            'Beschrijving'                => $this->field('post_content', ''),
            'Samenvatting'                => $this->meta('Samenvatting', ''),
            'Onderwerp'                   => $this->meta('Onderwerp', ''),
            'Beleidsterrein'              => $this->meta('Beleidsterrein', ''),
            'Partijen'                    => PartijenEntity::make($this->asNumeric($this->meta('Partijen', [])))->get(),
            'Inhoud'                      => $this->meta('Inhoud', ''),
            'Duur'                        => $this->meta('Duur', ''),
            'Datum_ondertekening'         => $this->meta('Datum_ondertekening', ''),
            'slug'                        => str_replace('openconvenanten-', '', $this->field('post_name', '')),
            'identifier'                  => $this->field('ID', ''),
        ];

        foreach ($this->asNumeric($this->meta('Bijlagen', [])) as $bijlage) {
            $bijlage = maybe_unserialize($bijlage);

            if (BijlageEntity::make($bijlage)->get()) {
                $data['Bijlagen'][] = BijlageEntity::make($bijlage)->get();
            }
        }

       
        return array_filter($data);
    }

    public function field(string $field, $default = null)
    {
        if (! array_key_exists($field, $this->data)) {
            return $default;
        }

        return trim((string) $this->data[$field]);
    }

    public function meta(string $key, $default = null)
    {
        $separator = '.';
        $key       = sprintf('%s_%s', 'convenant', $key);
        $data      = $this->data['meta'];
        // @assert $key is a non-empty string
        // @assert $data is a loopable array
        // @otherwise return $default value
        if (! is_string($key) || empty($key) || ! count($data)) {
            return $default;
        }

        // @assert $key contains a dot notated string
        if (false !== strpos($key, $separator)) {
            $keys = array_map(function ($key) {
                if (! preg_match('/^convenanten_/', $key)) {
                    return sprintf('%s_%s', 'convenanten', $key);
                }

                return $key;
            }, explode($separator, $key));

            foreach ($keys as $innerKey) {
                // @assert $data[$innerKey] is available to continue
                // @otherwise return $default value
                if (! array_key_exists($innerKey, $data)) {
                    return $default;
                }

                $data = $data[$innerKey];
            }

            return $data;
        }

        // @fallback returning value of $key in $data or $default value
        $data = $data[$key] ?? $default;

        // If there is a default but the types do not match, return default
        if (! is_null($default) && gettype($data) !== gettype($default)) {
            return $default;
        }
    
        return $data;
    }

    private function asNumeric(array $data): array
    {
        if (! empty($data[0])) {
            return $data;
        }

        return [0 => $data];
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
