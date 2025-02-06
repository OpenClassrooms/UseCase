<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\UseCases;

use Doctrine\Common\Annotations\Reader;
use OpenClassrooms\UseCase\Application\Services\Event\EventFactory;
use OpenClassrooms\UseCase\Application\Services\Event\EventSender;
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
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\CacheIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\EventFactoryIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\EventIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\LoggerIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\ReaderIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\SecurityIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\TransactionIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Impl\UseCaseProxyImpl;
use OpenClassrooms\UseCase\Application\Services\Security\Security;
use OpenClassrooms\UseCase\Application\Services\Transaction\Transaction;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
abstract class UseCaseProxyBuilder
{

    /**
     * @var UseCaseProxyImpl
     */
    protected $useCaseProxy;

    /**
     * @var CacheItemPoolInterface
     */
    private $cache;

    /**
     * @var EventSender
     */
    private $event;

    /**
     * @var EventFactory
     */
    private $eventFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var Security
     */
    private $security;

    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * @return UseCaseProxyBuilder
     * @codeCoverageIgnore
     */
    abstract public function create(UseCase $useCase);

    /**
     * @return UseCaseProxyBuilder
     */
    public function withCache(CacheItemPoolInterface $cache = null)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @return UseCaseProxyBuilder
     */
    public function withEventSender(EventSender $event = null)
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

    public function withLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

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
    public function withTransaction(Transaction $transaction = null)
    {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * @return UseCaseProxy
     */
    public function build()
    {
        if (null === $this->reader) {
            throw new ReaderIsNotDefinedException();
        }
        $this->checkStrategiesAvailability();
        $this->useCaseProxy->setReader($this->reader);
        $this->useCaseProxy->setProxyStrategyBagFactory($this->buildProxyStrategyBagFactory());
        $this->useCaseProxy->setProxyStrategyRequestFactory($this->buildProxyStrategyRequestFactory());

        return $this->useCaseProxy;
    }

    protected function checkStrategiesAvailability()
    {
        $annotations = $this->reader->getMethodAnnotations(
            new \ReflectionMethod($this->useCaseProxy->getUseCase(), 'execute')
        );

        foreach ($annotations as $annotation) {
            if ($annotation instanceof \OpenClassrooms\UseCase\Application\Annotations\Cache
                && null === $this->cache
            ) {
                throw new CacheIsNotDefinedException();
            }
            if ($annotation instanceof \OpenClassrooms\UseCase\Application\Annotations\Event
                && null === $this->event
            ) {
                throw new EventIsNotDefinedException();
            }
            if ($annotation instanceof \OpenClassrooms\UseCase\Application\Annotations\Event
                && null === $this->eventFactory
            ) {
                throw new EventFactoryIsNotDefinedException();
            }
            if ($annotation instanceof \OpenClassrooms\UseCase\Application\Annotations\Log
                && null === $this->logger
            ) {
                throw new LoggerIsNotDefinedException();
            }
            if ($annotation instanceof \OpenClassrooms\UseCase\Application\Annotations\Security
                && null === $this->security
            ) {
                throw new SecurityIsNotDefinedException();
            }
            if ($annotation instanceof \OpenClassrooms\UseCase\Application\Annotations\Transaction
                && null === $this->transaction
            ) {
                throw new TransactionIsNotDefinedException();
            }
        }
    }

    /**
     * @return ProxyStrategyBagFactoryImpl
     */
    protected function buildProxyStrategyBagFactory()
    {
        $proxyStrategyBagFactory = new ProxyStrategyBagFactoryImpl();
        if (null !== $this->cache) {
            $proxyStrategyBagFactory->setCacheStrategy($this->buildCacheStrategy());
        }
        if (null !== $this->event) {
            $proxyStrategyBagFactory->setEventStrategy($this->buildEventStrategy());
        }
        if (null !== $this->logger) {
            $proxyStrategyBagFactory->setLogStrategy($this->buildLogStrategy());
        }
        if (null !== $this->security) {
            $proxyStrategyBagFactory->setSecurityStrategy($this->buildSecurityStrategy());
        }
        if (null !== $this->transaction) {
            $proxyStrategyBagFactory->setTransactionStrategy($this->buildTransactionStrategy());
        }

        return $proxyStrategyBagFactory;
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
     * @return LogProxyStrategy
     */
    protected function buildLogStrategy()
    {
        $eventStrategy = new LogProxyStrategy();
        $eventStrategy->setLogger($this->logger);

        return $eventStrategy;
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
     * @return TransactionProxyStrategy
     */
    protected function buildTransactionStrategy()
    {
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
        $proxyStrategyRequestFactory->setCacheProxyStrategyRequestBuilder(new CacheProxyStrategyRequestBuilderImpl());
        $proxyStrategyRequestFactory->setEventProxyStrategyRequestBuilder(new EventProxyStrategyRequestBuilderImpl());
        $proxyStrategyRequestFactory->setLogProxyStrategyRequestBuilder(new LogProxyStrategyRequestBuilderImpl());
        $proxyStrategyRequestFactory->setSecurityProxyStrategyRequestBuilder(
            new SecurityProxyStrategyRequestBuilderImpl()
        );

        return $proxyStrategyRequestFactory;
    }
}
