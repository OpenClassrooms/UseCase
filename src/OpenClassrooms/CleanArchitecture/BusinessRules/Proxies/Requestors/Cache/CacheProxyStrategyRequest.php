<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\Cache;

use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\ProxyStrategyRequest;

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
