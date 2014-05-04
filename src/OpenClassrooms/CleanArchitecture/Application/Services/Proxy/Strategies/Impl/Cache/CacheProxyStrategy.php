<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Cache;

use OpenClassrooms\Cache\Cache\Cache;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\DTO\ProxyStrategyResponseDTO;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Cache\CacheProxyStrategyRequest;
use OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\ProxyStrategy;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequest;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Responders\ProxyStrategyResponse;

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
