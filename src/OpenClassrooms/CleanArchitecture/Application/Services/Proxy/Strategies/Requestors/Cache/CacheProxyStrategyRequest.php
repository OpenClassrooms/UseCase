<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Cache;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequest;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface CacheProxyStrategyRequest extends ProxyStrategyRequest
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getData();

    /**
     * @return string
     */
    public function getNamespaceId();

    /**
     * @return int
     */
    public function getLifeTime();
}
