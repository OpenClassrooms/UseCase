<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Event;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Event\Exceptions\EventNameMustBeDefinedException;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface EventProxyStrategyRequestBuilder
{
    /**
     * @return EventProxyStrategyRequestBuilder
     */
    public function create();

    /**
     * @return EventProxyStrategyRequestBuilder
     */
    public function withEventName($eventName);

    /**
     * @return EventProxyStrategyRequestBuilder
     */
    public function withUseCaseRequest(UseCaseRequest $useCaseRequest);

    /**
     * @return EventProxyStrategyRequestBuilder
     */
    public function withUseCaseResponse(UseCaseResponse $useCaseResponse);

    /**
     * @return EventProxyStrategyRequestBuilder
     */
    public function withException(\Exception $exception);

    /**
     * @return EventProxyStrategyRequest
     * @throws EventNameMustBeDefinedException
     */
    public function build();
}
