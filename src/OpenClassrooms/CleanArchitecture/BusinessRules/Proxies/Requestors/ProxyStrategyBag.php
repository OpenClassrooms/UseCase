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
    public function preExecute();

    /**
     * @return ProxyStrategyResponse
     */
    public function postExecute();

    /**
     * @return ProxyStrategyResponse
     */
    public function onException();
}
