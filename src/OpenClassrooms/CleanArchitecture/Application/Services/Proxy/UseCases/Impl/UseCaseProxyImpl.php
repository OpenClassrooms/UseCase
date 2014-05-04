<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\Impl;

use Doctrine\Common\Annotations\Reader;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyBagFactory;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequestFactory;
use OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\UseCaseProxy;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseProxyImpl extends UseCaseProxy
{
    public function setReader(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function setProxyStrategyBagFactory(ProxyStrategyBagFactory $proxyStrategyBagFactory)
    {
        $this->proxyStrategyBagFactory = $proxyStrategyBagFactory;
    }

    public function setProxyStrategyRequestFactory(ProxyStrategyRequestFactory $proxyStrategyRequestFactory)
    {
        $this->proxyStrategyRequestFactory = $proxyStrategyRequestFactory;
    }
}
