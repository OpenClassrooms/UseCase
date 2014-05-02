<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface ProxyStrategyBagFactory
{
    /**
     * @return ProxyStrategyBag
     */
    public function make($annotation);
}
