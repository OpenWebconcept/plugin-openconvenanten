<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\Repository;

use Yard\OpenConvenanten\Models\OpenConvenanten as OpenConvenantenModel;

/**
 * @OA\Schema(schema="repository")
 */
class OpenConvenantenRepository extends Base
{
    protected string $posttype = 'openconvenant-item';

    /** @inheritdoc */
    protected string $model = OpenConvenantenModel::class;

    /**
     * Add additional query arguments.
     */
    public function query(array $args): self
    {
        $this->queryArgs = array_merge($this->queryArgs, $args);

        return $this;
    }
}
