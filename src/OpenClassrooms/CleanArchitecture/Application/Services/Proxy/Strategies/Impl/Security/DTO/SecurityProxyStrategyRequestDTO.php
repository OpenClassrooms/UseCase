<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Security\DTO;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Security\SecurityProxyStrategyRequest;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class SecurityProxyStrategyRequestDTO implements SecurityProxyStrategyRequest
{
    /**
     * @var mixed
     */
    public $attributes;

    /**
     * @var mixed
     */
    public $object;

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }
}
