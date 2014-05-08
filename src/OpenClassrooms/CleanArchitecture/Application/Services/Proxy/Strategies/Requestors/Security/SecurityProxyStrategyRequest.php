<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Security;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequest;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface SecurityProxyStrategyRequest extends ProxyStrategyRequest
{
    /**
     * @return mixed
     */
    public function getAttributes();

    /**
     * @return mixed
     */
    public function getObject();
}
