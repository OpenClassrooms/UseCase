<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Cache\CacheProxyStrategy;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyBag;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheProxyStrategyBagImpl extends ProxyStrategyBag
{
    /**
     * @var CacheProxyStrategy
     */
    protected $proxyStrategy;

    /**
     * @var bool
     */
    protected $preExecute = true;

    /**
     * @var bool
     */
    protected $postExecute = true;

    public function isPostExecute()
    {
        /** @var $this ->proxyStrategy */

        return $this->proxyStrategy->isPostExecute();
    }
}
