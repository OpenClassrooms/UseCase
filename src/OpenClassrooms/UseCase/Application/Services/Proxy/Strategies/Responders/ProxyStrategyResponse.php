<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Responders;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface ProxyStrategyResponse
{
    /**
     * @return mixed
     */
    public function getData();

    /**
     * @return bool
     */
    public function stopExecution();
}
