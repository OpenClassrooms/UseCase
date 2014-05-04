<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl;

use Doctrine\Common\Annotations\Annotation;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Cache;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Event;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Security;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Transaction;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Exceptions\UnSupportedAnnotationException;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Cache\CacheProxyStrategy;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Transaction\TransactionProxyStrategy;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyBagFactory;

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
     * @var TransactionProxyStrategy
     */
    private $transactionStrategy;

    /**
     * @return ProxyStrategyBagImpl
     */
    public function make($annotation)
    {
        $strategyBag = new ProxyStrategyBagImpl();
        switch ($annotation) {
            case $annotation instanceof Security:
                break;
            case $annotation instanceof Cache:
                $strategyBag->setProxyStrategy($this->cacheStrategy);
                $strategyBag->setAnnotation($annotation);
                break;
            case $annotation instanceof Transaction:
                $strategyBag->setProxyStrategy($this->transactionStrategy);
                $strategyBag->setAnnotation($annotation);
                break;
            case $annotation instanceof Event:
                break;
            default:
                throw new UnSupportedAnnotationException();
        }

        return $strategyBag;
    }

    public function setCacheStrategy(CacheProxyStrategy $cacheStrategy)
    {
        $this->cacheStrategy = $cacheStrategy;
    }

    public function setTransactionStrategy(TransactionProxyStrategy $transactionStrategy)
    {
        $this->transactionStrategy = $transactionStrategy;
    }
}
