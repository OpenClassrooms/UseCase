<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Event\DTO;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Event\EventProxyStrategyRequest;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Event\EventProxyStrategyRequestBuilder;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Event\Exceptions\EventNameMustBeDefinedException;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class EventProxyStrategyRequestBuilderImpl implements EventProxyStrategyRequestBuilder
{
    /**
     * @var EventProxyStrategyRequestDTO
     */
    private $request;

    /**
     * @return EventProxyStrategyRequestBuilder
     */
    public function create()
    {
        $this->request = new EventProxyStrategyRequestDTO();

        return $this;
    }

    /**
     * @return EventProxyStrategyRequestBuilder
     */
    public function withEventName($eventName)
    {
        $this->request->eventName = $eventName;

        return $this;
    }

    /**
     * @return EventProxyStrategyRequestBuilder
     */
    public function withUseCaseRequest(UseCaseRequest $useCaseRequest)
    {
        $this->request->useCaseRequest = $useCaseRequest;

        return $this;
    }

    /**
     * @return EventProxyStrategyRequestBuilder
     */
    public function withUseCaseResponse(UseCaseResponse $useCaseResponse)
    {
        $this->request->useCaseResponse = $useCaseResponse;

        return $this;
    }

    /**
     * @return EventProxyStrategyRequestBuilder
     */
    public function withException(\Exception $exception)
    {
        $this->request->exception = $exception;

        return $this;
    }

    /**
     * @return EventProxyStrategyRequest
     * @throws EventNameMustBeDefinedException
     */
    public function build()
    {
        if (null === $this->request->getEventName()) {
            throw new EventNameMustBeDefinedException();
        }

        return $this->request;
    }
}
