<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Cache;

use Doctrine\Common\Cache\ArrayCache;
use OpenClassrooms\Cache\Cache\CacheImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheSpy extends CacheImpl
{
    /**
     * @var bool
     */
    public $saved = false;

    public function __construct()
    {
        parent::__construct(new ArrayCache());
    }

    public function save($id, $data, $lifeTime = null)
    {
        $this->saved = true;

        return parent::save($id, $data, $lifeTime);
    }
}
