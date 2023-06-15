<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\Repository;

use Yard\OpenConvenanten\Models\OpenConvenanten as OpenConvenantenModel;

/**
 * @OA\Schema(schema="repository")
 */
class OpenConvenantenRepository extends Base
{
    protected string $posttype = 'openconvenant-item';
    protected string $model = OpenConvenantenModel::class;

    /**
     * Add additional query arguments.
     */
    public function query(array $args): self
    {
        $this->queryArgs = array_merge($this->queryArgs, $args);

        return $this;
    }

    /**
     * Add parameters to tax_query used for filtering items on selected blog (ID) slugs.
     */
    public static function addShowOnParameter(string $blogSlug): array
    {
        return [
            'tax_query' => [
                [
                    'taxonomy' => 'openconvenanten-show-on',
                    'terms'    => sanitize_text_field($blogSlug),
                    'field'    => 'slug',
                    'operator' => 'IN'
                ]
            ]
        ];
    }
}
