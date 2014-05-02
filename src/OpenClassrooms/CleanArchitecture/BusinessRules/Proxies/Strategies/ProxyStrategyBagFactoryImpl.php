<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Strategies;

use Doctrine\Common\Annotations\Annotation;
use OpenClassrooms\CleanArchitecture\Annotations\Cache;
use OpenClassrooms\CleanArchitecture\Annotations\Event;
use OpenClassrooms\CleanArchitecture\Annotations\Security;
use OpenClassrooms\CleanArchitecture\Annotations\Transactional;
use
    OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\Cache\CacheProxyStrategyRequestBuilder;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\ProxyStrategyBagFactory;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Strategies\Cache\CacheProxyStrategy;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ProxyStrategyBagFactoryImpl implements ProxyStrategyBagFactory
{
    /**
     * @var CacheProxyStrategy
     */
    private $cacheStrategy;

    /**
     * @var CacheProxyStrategyRequestBuilder
     */
    private $cacheProxyStrategyRequestBuilder;

    /**
     * @return ProxyStrategyBagImpl
     */
    public function make($annotation, UseCaseRequest $useCaseRequest)
    {
        switch ($annotation) {
            case $annotation instanceof Security:
//                $strategyBag = $this->buildSecurityContainer($annotation);
                break;
            case $annotation instanceof Cache:
                $strategyBag = $this->buildCacheStrategyBag($annotation, $useCaseRequest);
                break;
            case $annotation instanceof Transactional:
//                $strategyBag = $this->buildTransactionalContainer();
                break;
            case $annotation instanceof Event:
//                $strategyBag = $this->buildEventContainer($annotation);
                break;
            default:
                throw new \Exception();
                break;
        }

        return $strategyBag;
    }

    private function buildCacheStrategyBag(Cache $annotation, UseCaseRequest $useCaseRequest)
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

        $cacheProxyStrategyRequest = $this->cacheProxyStrategyRequestBuilder
            ->withNamespaceId($namespaceId)
            ->withId(md5(serialize($useCaseRequest)))
            ->withLifeTime($annotation->getLifetime())
            ->build();

        $strategyBag = new ProxyStrategyBagImpl();
        $strategyBag->setProxyStrategy($this->cacheStrategy);
        $strategyBag->setProxyPreExecuteRequest($cacheProxyStrategyRequest);
        $strategyBag->setProxyPostExecuteRequest($cacheProxyStrategyRequest);
        $strategyBag->setProxyOnExceptionRequest($cacheProxyStrategyRequest);

        return $strategyBag;
    }

    public function setCacheStrategy(CacheProxyStrategy $cacheStrategy)
    {
        $this->cacheStrategy = $cacheStrategy;
    }

    public function setCacheProxyStrategyRequestBuilder(
        CacheProxyStrategyRequestBuilder $cacheProxyStrategyRequestBuilder
    )
    {
        $this->cacheProxyStrategyRequestBuilder = $cacheProxyStrategyRequestBuilder;
    }
}
