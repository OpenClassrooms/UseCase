<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Responders\ProxyStrategyResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface OnExceptionProxyStrategy extends ProxyStrategy
{
    /**
     * @return ProxyStrategyResponse
     */
    public function onException(ProxyStrategyRequest $proxyStrategyRequest);
}
