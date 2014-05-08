<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyBag;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TransactionProxyStrategyBagImpl extends ProxyStrategyBag
{
    /**
     * @var bool
     */
    protected $preExecute = true;

    /**
     * @var bool
     */
    protected $postExecute = true;

    /**
     * @var bool
     */
    protected $onException = true;
}
