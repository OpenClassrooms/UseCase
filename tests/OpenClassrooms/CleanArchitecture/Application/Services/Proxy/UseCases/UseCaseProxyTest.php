<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Services\Proxy\UseCases;

use Doctrine\Common\Annotations\AnnotationReader;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Cache\CacheProxyStrategy;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Cache\DTO\CacheProxyStrategyRequestBuilderImpl;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Event\DTO\EventProxyStrategyRequestBuilderImpl;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Event\EventProxyStrategy;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\ProxyStrategyBagFactoryImpl;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\ProxyStrategyRequestFactoryImpl;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Security\DTO\SecurityProxyStrategyRequestBuilderImpl;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Security\SecurityProxyStrategy;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Transaction\TransactionProxyStrategy;
use OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\Impl\UseCaseProxyImpl;
use OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\UseCaseProxy;
use OpenClassrooms\Tests\CleanArchitecture\Application\Services\Cache\CacheSpy;
use OpenClassrooms\Tests\CleanArchitecture\Application\Services\Event\EventFactorySpy;
use OpenClassrooms\Tests\CleanArchitecture\Application\Services\Event\EventSpy;
use OpenClassrooms\Tests\CleanArchitecture\Application\Services\Security\SecuritySpy;
use OpenClassrooms\Tests\CleanArchitecture\Application\Services\Transaction\TransactionSpy;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class UseCaseProxyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UseCaseProxy
     */
    protected $useCaseProxy;

    /**
     * @var CacheSpy
     */
    protected $cache;

    /**
     * @var EventSpy
     */
    protected $event;

    /**
     * @var EventFactorySpy
     */
    protected $eventFactory;

    /**
     * @var SecuritySpy
     */
    protected $security;

    /**
     * @var TransactionSpy
     */
    protected $transaction;

    protected function setUp()
    {
        $this->useCaseProxy = new UseCaseProxyImpl();
        $this->useCaseProxy->setReader(new AnnotationReader());

        $this->useCaseProxy->setProxyStrategyBagFactory($this->buildProxyStrategyBagFactory());
        $this->useCaseProxy->setProxyStrategyRequestFactory(
            $this->buildProxyStrategyRequestFactory()
        );
    }

    /**
     * @return ProxyStrategyBagFactoryImpl
     */
    protected function buildProxyStrategyBagFactory()
    {
        $proxyStrategyBagFactory = new ProxyStrategyBagFactoryImpl();
        $proxyStrategyBagFactory->setCacheStrategy($this->buildCacheStrategy());
        $proxyStrategyBagFactory->setEventStrategy($this->buildEventStrategy());
        $proxyStrategyBagFactory->setSecurityStrategy($this->buildSecurityStrategy());
        $proxyStrategyBagFactory->setTransactionStrategy($this->buildTransactionStrategy());

        return $proxyStrategyBagFactory;
    }

    /**
     * @return CacheProxyStrategy
     */
    protected function buildCacheStrategy()
    {
        $this->cache = new CacheSpy();

        $cacheStrategy = new CacheProxyStrategy();
        $cacheStrategy->setCache($this->cache);

        return $cacheStrategy;
    }

    /**
     * @return EventProxyStrategy
     */
    protected function buildEventStrategy()
    {
        $this->event = new EventSpy();
        $eventStrategy = new EventProxyStrategy();
        $eventStrategy->setEvent($this->event);
        $this->eventFactory = new EventFactorySpy();
        $eventStrategy->setEventFactory($this->eventFactory);

        return $eventStrategy;
    }

    /**
     * @return SecurityProxyStrategy
     */
    protected function buildSecurityStrategy()
    {
        $this->security = new SecuritySpy();

        $securityStrategy = new SecurityProxyStrategy();
        $securityStrategy->setSecurity($this->security);

        return $securityStrategy;
    }

    /**
     * @return TransactionProxyStrategy
     */
    protected function buildTransactionStrategy()
    {
        $this->transaction = new TransactionSpy();

        $transactionStrategy = new TransactionProxyStrategy();
        $transactionStrategy->setTransaction($this->transaction);

        return $transactionStrategy;
    }

    /**
     * @return ProxyStrategyRequestFactoryImpl
     */
    protected function buildProxyStrategyRequestFactory()
    {
        $proxyStrategyRequestFactory = new ProxyStrategyRequestFactoryImpl();
        $proxyStrategyRequestFactory->setCacheProxyStrategyRequestBuilder(
            new CacheProxyStrategyRequestBuilderImpl()
        );
        $proxyStrategyRequestFactory->setEventProxyStrategyRequestBuilder(
            new EventProxyStrategyRequestBuilderImpl()
        );
        $proxyStrategyRequestFactory->setSecurityProxyStrategyRequestBuilder(
            new SecurityProxyStrategyRequestBuilderImpl()
        );

        return $proxyStrategyRequestFactory;
    }
}
