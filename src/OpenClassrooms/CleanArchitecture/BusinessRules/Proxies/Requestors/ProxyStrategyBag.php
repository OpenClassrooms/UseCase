<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors;

use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Responders\ProxyStrategyResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface ProxyStrategyBag
{
    /**
     * @return ProxyStrategyResponse
     */
    public function preExecute(ProxyStrategyRequest $proxyStrategyRequest);

    /**
     * @return ProxyStrategyResponse
     */
    public function postExecute(ProxyStrategyRequest $proxyStrategyRequest);

    /**
     * @return ProxyStrategyResponse
     */
    public function onException(ProxyStrategyRequest $proxyStrategyRequest);
}
