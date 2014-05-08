<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Event;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Event\Exceptions\InvalidEventNameException;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface EventFactory
{
    /**
     * @return mixed
     * @throws InvalidEventNameException
     */
    public function make(
        $eventName,
        UseCaseRequest $useCaseRequest = null,
        UseCaseResponse $useCaseResponse = null,
        \Exception $exception = null
    );
}
