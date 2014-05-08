<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Event;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface EventProxyStrategyRequest extends ProxyStrategyRequest
{
    /**
     * @return string
     */
    public function getEventName();

    /**
     * @return \Exception
     */
    public function getException();

    /**
     * @return UseCaseRequest
     */
    public function getUseCaseRequest();

    /**
     * @return UseCaseResponse
     */
    public function getUseCaseResponse();
}
