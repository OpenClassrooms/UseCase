<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors;

use Doctrine\Common\Cache\Cache;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Event;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Transaction;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Responders\ProxyStrategyResponse;
use OpenClassrooms\CleanArchitecture\Application\Services\Security\Security;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class ProxyStrategyBag
{
    /**
     * @var Security|Cache|Transaction|Event
     */
    protected $annotation;

    /**
     * @var ProxyStrategy|PreExecuteProxyStrategy|PostExecuteProxyStrategy|OnExceptionProxyStrategy
     */
    protected $proxyStrategy;

    /**
     * @var bool
     */
    protected $preExecute = false;

    /**
     * @var bool
     */
    protected $postExecute = false;

    /**
     * @var bool
     */
    protected $onException = false;

    public function __construct(ProxyStrategy $proxyStrategy)
    {
        $this->proxyStrategy = $proxyStrategy;
    }

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

    /**
     * @return boolean
     */
    public function isPreExecute()
    {
        return $this->preExecute;
    }

    /**
     * @return boolean
     */
    public function isPostExecute()
    {
        return $this->postExecute;
    }

    /**
     * @return boolean
     */
    public function isOnException()
    {
        return $this->onException;
    }
}
