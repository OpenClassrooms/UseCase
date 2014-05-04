<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Responders;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
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
