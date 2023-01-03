<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\Repository;

use Yard\OpenConvenanten\Models\OpenConvenanten as OpenConvenantenModel;

/**
 * @OA\Schema(schema="repository")
 */
class OpenConvenantenRepository extends Base
{
    protected $posttype = 'openconvenant-item';

    /** @inheritdoc */
    protected $model = OpenConvenantenModel::class;

    protected static $globalFields = [];

    /**
     * Add additional query arguments.
     */
    public function query(array $args): self
    {
        $this->queryArgs = array_merge($this->queryArgs, $args);

        return $this;
    }
}
