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
abstract class AbstractUseCaseProxyTest extends \PHPUnit_Framework_TestCase
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

    /**
     * @var ProxyStrategyBagFactoryImpl
     */
    private $proxyStrategyBagFactory;

    /**
     * @var ProxyStrategyRequestFactoryImpl
     */
    private $proxyStrategyRequestFactory;

    protected function setUp()
    {
        $this->initUseCaseProxy();

        $this->buildSecurityStrategy();
        $this->buildCacheStrategy();
        $this->buildTransactionStrategy();
        $this->buildEventStrategy();

    }

    protected function initUseCaseProxy()
    {
        $this->useCaseProxy = new UseCaseProxyImpl();
        $this->useCaseProxy->setReader(new AnnotationReader());

        $this->proxyStrategyBagFactory = new ProxyStrategyBagFactoryImpl();
        $this->proxyStrategyRequestFactory = new ProxyStrategyRequestFactoryImpl();
        $this->useCaseProxy->setProxyStrategyBagFactory($this->proxyStrategyBagFactory);
        $this->useCaseProxy->setProxyStrategyRequestFactory($this->proxyStrategyRequestFactory);
    }

    /**
     * @return SecurityProxyStrategy
     */
    protected function buildSecurityStrategy()
    {
        $this->security = new SecuritySpy();

        $securityStrategy = new SecurityProxyStrategy();
        $securityStrategy->setSecurity($this->security);
        $this->proxyStrategyBagFactory->setSecurityStrategy($securityStrategy);
        $this->proxyStrategyRequestFactory->setSecurityProxyStrategyRequestBuilder(
            new SecurityProxyStrategyRequestBuilderImpl()
        );
    }

    /**
     * @return CacheProxyStrategy
     */
    protected function buildCacheStrategy()
    {
        $this->cache = new CacheSpy();
        $cacheStrategy = new CacheProxyStrategy();
        $cacheStrategy->setCache($this->cache);

        $this->proxyStrategyBagFactory->setCacheStrategy($cacheStrategy);

        $this->proxyStrategyRequestFactory->setCacheProxyStrategyRequestBuilder(
            new CacheProxyStrategyRequestBuilderImpl()
        );
    }

    /**
     * @return TransactionProxyStrategy
     */
    protected function buildTransactionStrategy()
    {
        $this->transaction = new TransactionSpy();

        $transactionStrategy = new TransactionProxyStrategy();
        $transactionStrategy->setTransaction($this->transaction);
        $this->proxyStrategyBagFactory->setTransactionStrategy($transactionStrategy);
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

        $this->proxyStrategyBagFactory->setEventStrategy($eventStrategy);
        $this->proxyStrategyRequestFactory->setEventProxyStrategyRequestBuilder(
            new EventProxyStrategyRequestBuilderImpl()
        );
    }
}
