<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Event;

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\ExceptionUseCaseStub;
use OpenClassrooms\UseCase\Application\Annotations\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OnExceptionEventUseCaseStub extends ExceptionUseCaseStub
{
    const EVENT_NAME = 'on_exception_event_use_case_stub';

    /**
     * @event (methods="onException")
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }

}
