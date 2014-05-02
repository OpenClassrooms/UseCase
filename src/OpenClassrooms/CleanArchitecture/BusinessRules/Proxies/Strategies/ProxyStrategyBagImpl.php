<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Strategies;

use OpenClassrooms\CleanArchitecture\Annotations\Cache;
use OpenClassrooms\CleanArchitecture\Annotations\Event;
use OpenClassrooms\CleanArchitecture\Annotations\Security;
use OpenClassrooms\CleanArchitecture\Annotations\Transaction;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\ProxyStrategy;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\ProxyStrategyBag;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\ProxyStrategyRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Responders\ProxyStrategyResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ProxyStrategyBagImpl implements ProxyStrategyBag
{
    /**
     * @var Security|Cache|Transaction|Event
     */
    private $annotation;

    /**
     * @var ProxyStrategy
     */
    private $proxyStrategy;

    /**
     * @return ProxyStrategyResponse
     */
    public function preExecute(ProxyStrategyRequest $proxyStrategyRequest)
    {
        return $this->proxyStrategy->preExecute($proxyStrategyRequest);
    }

    /**
     * @return ProxyStrategyResponse
     */
    public function postExecute(ProxyStrategyRequest $proxyStrategyRequest)
    {
        return $this->proxyStrategy->postExecute($proxyStrategyRequest);
    }

    /**
     * @return ProxyStrategyResponse
     */
    public function onException(ProxyStrategyRequest $proxyStrategyRequest)
    {
        return $this->proxyStrategy->onException($proxyStrategyRequest);
    }

    public function setProxyStrategy(ProxyStrategy $proxyStrategy)
    {
        $this->proxyStrategy = $proxyStrategy;
    }

    /**
     * @return Cache|Event|Security|Transaction
     */
    public function getAnnotation()
    {
        return $this->annotation;
    }

    public function setAnnotation($annotation)
    {
        $this->annotation = $annotation;
    }
}
