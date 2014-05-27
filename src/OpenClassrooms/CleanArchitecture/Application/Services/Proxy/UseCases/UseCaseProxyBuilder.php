<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases;

use Doctrine\Common\Annotations\Reader;
use OpenClassrooms\Cache\Cache\Cache;
use OpenClassrooms\CleanArchitecture\Application\Services\Event\Event;
use OpenClassrooms\CleanArchitecture\Application\Services\Event\EventFactory;
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
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\Exceptions\ReaderIsNotDefinedException;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\Exceptions\UseCaseIsNotDefineException;
use OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\Impl\UseCaseProxyImpl;
use OpenClassrooms\CleanArchitecture\Application\Services\Security\Security;
use OpenClassrooms\CleanArchitecture\Application\Services\Transaction\Transaction;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class UseCaseProxyBuilder
{
    /**
     * @var UseCaseProxyImpl
     */
    protected $useCaseProxy;

    /**
     * @var Security
     */
    private $security;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * @var Event
     */
    private $event;

    /**
     * @var EventFactory
     */
    private $eventFactory;

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @return UseCaseProxyBuilder
     * @codeCoverageIgnore
     */
    abstract public function create(UseCase $useCase);

    /**
     * @return UseCaseProxyBuilder
     */
    public function withSecurity(Security $security = null)
    {
        $this->security = $security;

        return $this;
    }

    /**
     * @return UseCaseProxyBuilder
     */
    public function withCache(Cache $cache = null)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @return UseCaseProxyBuilder
     */
    public function withTransaction(Transaction $transaction = null)
    {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * @return UseCaseProxyBuilder
     */
    public function withEvent(Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return UseCaseProxyBuilder
     */
    public function withEventFactory(EventFactory $eventFactory = null)
    {
        $this->eventFactory = $eventFactory;

        return $this;
    }

    /**
     * @return UseCaseProxyBuilder
     */
    public function withReader(Reader $reader)
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * @return UseCaseProxy
     * @throws UseCaseIsNotDefineException
     */
    public function build()
    {
        if (null === $this->reader) {
            throw new ReaderIsNotDefinedException();
        }
        $this->useCaseProxy->setReader($this->reader);
        $this->useCaseProxy->setProxyStrategyBagFactory($this->buildProxyStrategyBagFactory());
        $this->useCaseProxy->setProxyStrategyRequestFactory(
            $this->buildProxyStrategyRequestFactory()
        );

        return $this->useCaseProxy;
    }

    /**
     * @return ProxyStrategyBagFactoryImpl
     */
    protected function buildProxyStrategyBagFactory()
    {
        $proxyStrategyBagFactory = new ProxyStrategyBagFactoryImpl();
        if (null !== $this->security) {
            $proxyStrategyBagFactory->setSecurityStrategy($this->buildSecurityStrategy());
        }
        if (null !== $this->cache) {
            $proxyStrategyBagFactory->setCacheStrategy($this->buildCacheStrategy());
        }
        if (null !== $this->transaction) {
            $proxyStrategyBagFactory->setTransactionStrategy($this->buildTransactionStrategy());
        }
        if (null !== $this->event) {
            $proxyStrategyBagFactory->setEventStrategy($this->buildEventStrategy());
        }

        return $proxyStrategyBagFactory;
    }

    /**
     * @return SecurityProxyStrategy
     */
    protected function buildSecurityStrategy()
    {
        $securityStrategy = new SecurityProxyStrategy();
        $securityStrategy->setSecurity($this->security);

        return $securityStrategy;
    }

    /**
     * @return CacheProxyStrategy
     */
    protected function buildCacheStrategy()
    {
        $cacheStrategy = new CacheProxyStrategy();
        $cacheStrategy->setCache($this->cache);

        return $cacheStrategy;
    }

    /**
     * @return TransactionProxyStrategy
     */
    protected function buildTransactionStrategy()
    {
        $transactionStrategy = new TransactionProxyStrategy();
        $transactionStrategy->setTransaction($this->transaction);

        return $transactionStrategy;
    }

    /**
     * @return EventProxyStrategy
     */
    protected function buildEventStrategy()
    {
        $eventStrategy = new EventProxyStrategy();
        $eventStrategy->setEvent($this->event);
        $eventStrategy->setEventFactory($this->eventFactory);

        return $eventStrategy;
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
