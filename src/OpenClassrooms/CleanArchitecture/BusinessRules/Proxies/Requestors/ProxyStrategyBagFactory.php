<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface ProxyStrategyBagFactory
{
    /**
     * @return ProxyStrategyBag
     */
    public function make($annotation, UseCaseRequest $useCaseRequest);
}
