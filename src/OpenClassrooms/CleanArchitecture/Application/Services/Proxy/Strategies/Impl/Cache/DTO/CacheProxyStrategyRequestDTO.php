<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Cache\DTO;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Cache\CacheProxyStrategyRequest;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheProxyStrategyRequestDTO implements CacheProxyStrategyRequest
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $data;

    /**
     * @var string
     */
    public $namespaceId;

    /**
     * @var int
     */
    public $lifeTime;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getLifeTime()
    {
        return $this->lifeTime;
    }

    /**
     * @return string
     */
    public function getNamespaceId()
    {
        return $this->namespaceId;
    }
}
