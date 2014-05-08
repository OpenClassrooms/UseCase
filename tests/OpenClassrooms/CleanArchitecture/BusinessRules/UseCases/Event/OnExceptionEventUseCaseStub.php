<?php

namespace OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\Event;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\ExceptionUseCaseStub;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OnExceptionEventUseCaseStub extends ExceptionUseCaseStub
{
    const EVENT_NAME = 'event_name';

    /**
     * @event (name="event_name", methods="onException")
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }

}
