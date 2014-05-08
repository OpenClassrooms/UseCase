<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Security\DTO;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Security\Exceptions\AttributesMustBeDefinedException;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Security\SecurityProxyStrategyRequest;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Security\SecurityProxyStrategyRequestBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class SecurityProxyStrategyRequestBuilderImpl implements SecurityProxyStrategyRequestBuilder
{
    /**
     * @var SecurityProxyStrategyRequestDTO
     */
    private $request;

    /**
     * @return SecurityProxyStrategyRequestBuilder
     */
    public function create()
    {
        $this->request = new SecurityProxyStrategyRequestDTO();

        return $this;
    }

    /**
     * @return SecurityProxyStrategyRequestBuilder
     */
    public function withAttributes($attributes)
    {
        $this->request->attributes = $attributes;

        return $this;
    }

    /**
     * @return SecurityProxyStrategyRequestBuilder
     */
    public function withObject($object)
    {
        $this->request->object = $object;

        return $this;
    }

    /**
     * @return SecurityProxyStrategyRequest
     */
    public function build()
    {
        if (null === $this->request->attributes) {
            throw new AttributesMustBeDefinedException();
        }

        return $this->request;
    }
}
