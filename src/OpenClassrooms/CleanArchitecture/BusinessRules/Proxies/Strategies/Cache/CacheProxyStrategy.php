<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Strategies\Cache;

use OpenClassrooms\Cache\Cache\Cache;
use
    OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\Cache\CacheProxyStrategyRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\ProxyStrategy;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\ProxyStrategyRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Responders\ProxyStrategyResponse;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Strategies\DTO\ProxyStrategyResponseDTO;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheProxyStrategy implements ProxyStrategy
{
    /**
     * @var Cache
     */
    private $cache;

    /**
     * @return ProxyStrategyResponse
     */
    public function preExecute(ProxyStrategyRequest $proxyStrategyRequest)
    {
        /** @var CacheProxyStrategyRequest $proxyStrategyRequest */
        $data = $this->cache->fetchWithNamespace(
            $proxyStrategyRequest->getId(),
            $proxyStrategyRequest->getNamespaceId()
        );

        $data ? $stopExecution = true : $stopExecution = false;

        return new ProxyStrategyResponseDTO($data, $stopExecution);
    }

    /**
     * @return ProxyStrategyResponse
     */
    public function postExecute(ProxyStrategyRequest $proxyStrategyRequest)
    {
        /** @var CacheProxyStrategyRequest $proxyStrategyRequest */
        $saved = $this->cache->saveWithNamespace(
            $proxyStrategyRequest->getId(),
            $proxyStrategyRequest->getData(),
            $proxyStrategyRequest->getNamespaceId(),
            $proxyStrategyRequest->getLifeTime()
        );

        return new ProxyStrategyResponseDTO($saved, false);
    }

    /**
     * @return ProxyStrategyResponse
     */
    public function onException(ProxyStrategyRequest $proxyStrategyRequest)
    {
        return new ProxyStrategyResponseDTO();
    }

    public function setCache(Cache $cache)
    {
        $this->cache = $cache;
    }
}
