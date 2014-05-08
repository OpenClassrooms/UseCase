<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Responders\ProxyStrategyResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface PreExecuteProxyStrategy extends ProxyStrategy
{
    /**
     * @return ProxyStrategyResponse
     */
    public function preExecute(ProxyStrategyRequest $proxyStrategyRequest);
}
