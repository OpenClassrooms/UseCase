<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Cache;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\DTO\ProxyStrategyResponseDTO;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Cache\CacheProxyStrategyRequest;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\PostExecuteProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\PreExecuteProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequest;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Responders\ProxyStrategyResponse;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class CacheProxyStrategy implements PreExecuteProxyStrategy, PostExecuteProxyStrategy
{
    /**
     * @var CacheItemPoolInterface
     */
    private $cache;

    /**
     * @var bool
     */
    private $postExecute;

    /**
     * @return string
     */
    public function getType()
    {
        return ProxyStrategy::CACHE;
    }

    /**
     * @return ProxyStrategyResponse
     */
    public function preExecute(ProxyStrategyRequest $proxyStrategyRequest)
    {
        /** @var CacheProxyStrategyRequest $proxyStrategyRequest */
        $item = $this->fetchWithNamespace(
            $proxyStrategyRequest->getId(),
            $proxyStrategyRequest->getNamespaceId()
        );

        $this->postExecute = !$item->isHit();

        return new ProxyStrategyResponseDTO($item->get(), $item->isHit());
    }

    /**
     * @return ProxyStrategyResponse
     */
    public function postExecute(ProxyStrategyRequest $proxyStrategyRequest)
    {
        /** @var CacheProxyStrategyRequest $proxyStrategyRequest */
        $item = $this->saveWithNamespace(
            $proxyStrategyRequest->getId(),
            $proxyStrategyRequest->getData(),
            $proxyStrategyRequest->getNamespaceId(),
            $proxyStrategyRequest->getLifeTime()
        );

        return new ProxyStrategyResponseDTO($item->get(), false);
    }

    private function fetchWithNamespace(string $id, string $namespace = null): CacheItemInterface
    {
        if ($namespace !== null) {
            $namespaceId = $this->cache->getItem($namespace);

            $id = ((string) $namespaceId->get()) . $id;
        }

        return $this->cache->getItem($id);
    }

    private function saveWithNamespace(string $id, mixed $data, string $namespace = null, int $lifetime = null): CacheItemInterface
    {
        if ($namespace !== null) {
            $namespaceId = $this->cache->getItem($namespace);

            if (!$namespaceId->isHit()) {
                $namespaceId->set($namespace . '_' . random_int(0, 10000));
                $namespaceId->expiresAfter(604800); // 7 days

                $this->cache->save($namespaceId);
            }

            $id = ((string) $namespaceId->get()) . $id;
        }

        $item = $this->cache->getItem($id);
        $item->set($data)->expiresAfter($lifetime);

        $this->cache->save($item);

        return $item;
    }


    /**
     * @return boolean
     */
    public function isPostExecute()
    {
        return $this->postExecute;
    }

    public function setCache(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }
}
