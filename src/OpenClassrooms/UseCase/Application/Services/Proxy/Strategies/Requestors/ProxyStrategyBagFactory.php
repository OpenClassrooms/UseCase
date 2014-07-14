<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface ProxyStrategyBagFactory
{
    /**
     * @return ProxyStrategyBag
     */
    public function make($annotation);
}
