<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\UseCases;

use Doctrine\Common\Annotations\Reader;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\ProxyStrategyBagFactory;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\ProxyStrategyRequestFactory;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseProxy;

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
