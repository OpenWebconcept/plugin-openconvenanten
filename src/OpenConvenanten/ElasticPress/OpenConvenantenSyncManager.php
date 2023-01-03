<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\ElasticPress;

use ElasticPress\Indexable\Post\SyncManager;

class OpenConvenantenSyncManager extends SyncManager
{
    /**
     * Indexable slug
     *
     * @since  3.0
     *
     * @var    string
     */
    public $indexable_slug = 'openconvenant-item';
}
