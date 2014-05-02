<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Strategies;

use OpenClassrooms\CleanArchitecture\Annotations\Cache;
use OpenClassrooms\CleanArchitecture\Annotations\Event;
use OpenClassrooms\CleanArchitecture\Annotations\Security;
use OpenClassrooms\CleanArchitecture\Annotations\Transaction;
use
    OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\Cache\CacheProxyStrategyRequestBuilder;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\ProxyStrategyRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\ProxyStrategyRequestFactory;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Strategies\DTO\ProxyStrategyRequestDTO;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ProxyStrategyRequestFactoryImpl implements ProxyStrategyRequestFactory
{
    /**
     * @var CacheProxyStrategyRequestBuilder
     */
    private $cacheProxyStrategyRequestBuilder;

    /**
     * @return ProxyStrategyRequest
     */
    public function createPreExecuteRequest($annotation, UseCaseRequest $useCaseRequest)
    {
        $request = new ProxyStrategyRequestDTO();
        switch ($annotation) {
            case $annotation instanceof Security:
                break;
            case $annotation instanceof Cache:
                /** @var Cache $annotation */
                $request = $this->cacheProxyStrategyRequestBuilder
                    ->withNamespaceId($this->getNamespaceId($annotation, $useCaseRequest))
                    ->withId(md5(serialize($useCaseRequest)))
                    ->withLifeTime($annotation->getLifetime())
                    ->build();
                break;
            case $annotation instanceof Transaction:
                break;
            case $annotation instanceof Event:
                break;
            default:
                $request = new ProxyStrategyRequestDTO();
                break;
        }

        return $request;
    }

    /**
     * @return string|null
     */
    private function getNamespaceId(Cache $annotation, UseCaseRequest $useCaseRequest)
    {
        $namespaceId = null;
        if (null !== $annotation->getNamespacePrefix()) {
            $namespaceId = $annotation->getNamespacePrefix();
        }
        if (null !== $namespaceAttribute = $annotation->getNamespaceAttribute()) {
            $reflectionClass = new \ReflectionClass($useCaseRequest);
            $property = $reflectionClass->getProperty($namespaceAttribute);
            $property->setAccessible(true);
            null === $namespaceId ? $namespaceId = $property->getValue($useCaseRequest)
                : $namespaceId .= $property->getValue($useCaseRequest);
        }

        return $namespaceId;
    }

    /**
     * @return ProxyStrategyRequest
     */
    public function createPostExecuteRequest(
        $annotation,
        UseCaseRequest $useCaseRequest,
        UseCaseResponse $useCaseResponse
    )
    {
        $request = new ProxyStrategyRequestDTO();
        switch ($annotation) {
            case $annotation instanceof Security:
                break;
            case $annotation instanceof Cache:
                /** @var Cache $annotation */
                $request = $this->cacheProxyStrategyRequestBuilder
                    ->withNamespaceId($this->getNamespaceId($annotation, $useCaseRequest))
                    ->withId(md5(serialize($useCaseRequest)))
                    ->withLifeTime($annotation->getLifetime())
                    ->withData($useCaseResponse)
                    ->build();
                break;
            case $annotation instanceof Transaction:
                break;
            case $annotation instanceof Event:
                break;
            default:
                $request = new ProxyStrategyRequestDTO();
                break;
        }

        return $request;
    }

    /**
     * @return ProxyStrategyRequest
     */
    public function createOnExceptionRequest($annotation, UseCaseRequest $useCaseRequest)
    {
        return new ProxyStrategyRequestDTO();
    }

    public function setCacheProxyStrategyRequestBuilder(
        CacheProxyStrategyRequestBuilder $cacheProxyStrategyRequestBuilder
    )
    {
        $this->cacheProxyStrategyRequestBuilder = $cacheProxyStrategyRequestBuilder;
    }
}
