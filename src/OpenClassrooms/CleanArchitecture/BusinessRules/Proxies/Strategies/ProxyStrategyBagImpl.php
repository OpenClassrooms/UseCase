<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Strategies;

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
     * @var ProxyStrategyRequest
     */
    private $proxyPreExecuteRequest;

    /**
     * @var ProxyStrategyRequest
     */
    private $proxyPostExecuteRequest;

    /**
     * @var ProxyStrategyRequest
     */
    private $proxyOnExceptionRequest;

    /**
     * @var ProxyStrategy
     */
    private $proxyStrategy;

    /**
     * @return ProxyStrategyResponse
     */
    public function preExecute()
    {
        return $this->proxyStrategy->preExecute($this->proxyPreExecuteRequest);
    }

    /**
     * @return ProxyStrategyResponse
     */
    public function postExecute()
    {
        return $this->proxyStrategy->postExecute($this->proxyPostExecuteRequest);
    }

    /**
     * @return ProxyStrategyResponse
     */
    public function onException()
    {
        return $this->proxyStrategy->onException($this->proxyOnExceptionRequest);
    }

    public function setProxyOnExceptionRequest(ProxyStrategyRequest $proxyOnExceptionRequest)
    {
        $this->proxyOnExceptionRequest = $proxyOnExceptionRequest;
    }

    public function setProxyPostExecuteRequest(ProxyStrategyRequest $proxyPostExecuteRequest)
    {
        $this->proxyPostExecuteRequest = $proxyPostExecuteRequest;
    }

    public function setProxyPreExecuteRequest(ProxyStrategyRequest $proxyPreExecuteRequest)
    {
        $this->proxyPreExecuteRequest = $proxyPreExecuteRequest;
    }

    public function setProxyStrategy(ProxyStrategy $proxyStrategy)
    {
        $this->proxyStrategy = $proxyStrategy;
    }
}
