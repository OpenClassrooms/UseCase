<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Event\DTO;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Event\EventProxyStrategyRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class EventProxyStrategyRequestDTO implements EventProxyStrategyRequest
{
    /**
     * @var string
     */
    public $eventName;

    /**
     * @var UseCaseRequest
     */
    public $useCaseRequest;

    /**
     * @var UseCaseResponse
     */
    public $useCaseResponse;

    /**
     * @var \Exception
     */
    public $exception;

    /**
     * @return string
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @return UseCaseRequest
     */
    public function getUseCaseRequest()
    {
        return $this->useCaseRequest;
    }

    /**
     * @return UseCaseResponse
     */
    public function getUseCaseResponse()
    {
        return $this->useCaseResponse;
    }
}
