<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Proxy\UseCases;

use Doctrine\Common\Annotations\AnnotationReader;
use OpenClassrooms\Tests\UseCase\Application\Services\Cache\CacheSpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Event\EventFactorySpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Event\EventSenderSpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Log\LoggerSpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Security\SecuritySpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Transaction\TransactionSpy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Cache\CacheProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Cache\DTO\CacheProxyStrategyRequestBuilderImpl;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Event\DTO\EventProxyStrategyRequestBuilderImpl;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Event\EventProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Log\DTO\LogProxyStrategyRequestBuilderImpl;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Log\LogProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\ProxyStrategyBagFactoryImpl;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\ProxyStrategyRequestFactoryImpl;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Security\DTO\SecurityProxyStrategyRequestBuilderImpl;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Security\SecurityProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Transaction\TransactionProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Impl\UseCaseProxyImpl;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxy;
use PHPUnit\Framework\TestCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
abstract class AbstractUseCaseProxyTestCase extends TestCase
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
     * @var string[]
     */
    protected array $logs = [];

    /**
     * @var EventSenderSpy
     */
    protected $event;

    /**
     * @var EventFactorySpy
     */
    protected $eventFactory;

    /**
     * @var LoggerSpy
     */
    protected $logger;

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

    protected function setUp(): void
    {
        $this->initUseCaseProxy();

        $this->buildSecurityStrategy();
        $this->buildCacheStrategy();
        $this->buildTransactionStrategy();
        $this->buildEventStrategy();
        $this->buildLogStrategy();
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
        $this->event = new EventSenderSpy();
        $eventStrategy = new EventProxyStrategy();
        $eventStrategy->setEvent($this->event);
        $this->eventFactory = new EventFactorySpy();
        $eventStrategy->setEventFactory($this->eventFactory);

        $this->proxyStrategyBagFactory->setEventStrategy($eventStrategy);
        $this->proxyStrategyRequestFactory->setEventProxyStrategyRequestBuilder(
            new EventProxyStrategyRequestBuilderImpl()
        );
    }

    protected function buildLogStrategy()
    {
        $this->logger = new LoggerSpy();
        $logStrategy = new LogProxyStrategy();
        $logStrategy->setLogger($this->logger);

        $this->proxyStrategyBagFactory->setLogStrategy($logStrategy);
        $this->proxyStrategyRequestFactory->setLogProxyStrategyRequestBuilder(new LogProxyStrategyRequestBuilderImpl());
    }

    protected function tearDown(): void
    {
        LoggerSpy::$context = array();
        LoggerSpy::$level = array();
        LoggerSpy::$message = array();
    }
}
