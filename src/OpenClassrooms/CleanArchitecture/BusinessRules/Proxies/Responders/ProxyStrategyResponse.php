<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Responders;

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
