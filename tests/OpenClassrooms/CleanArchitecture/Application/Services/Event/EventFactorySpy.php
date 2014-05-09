<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Services\Event;

use OpenClassrooms\CleanArchitecture\Application\Services\Event\EventFactory;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Event\Exceptions\InvalidEventNameException;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;
use
    OpenClassrooms\Tests\CleanArchitecture\Application\Services\Security\Exceptions\AccessDeniedException;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class EventFactorySpy implements EventFactory
{
    const INVALID_EVENT_NAME = 'invalid_event_name';

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
     * @return mixed
     * @throws InvalidEventNameException
     */
    public function make(
        $eventName,
        UseCaseRequest $useCaseRequest = null,
        UseCaseResponse $useCaseResponse = null,
        \Exception $exception = null
    )
    {
        $this->useCaseRequest = $useCaseRequest;
        $this->useCaseResponse = $useCaseResponse;
        $this->exception = $exception;

        if (self::INVALID_EVENT_NAME === $eventName) {
            throw new InvalidEventNameException($eventName);
        }

        if ($exception instanceof AccessDeniedException) {
            throw $exception;
        }

        return $eventName;
    }

}
