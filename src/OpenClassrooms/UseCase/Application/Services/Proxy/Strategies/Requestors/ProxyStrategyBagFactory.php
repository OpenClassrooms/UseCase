<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors;

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
