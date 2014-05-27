<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Event;

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\UseCase\Application\Annotations\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class PostEventUseCaseStub extends UseCaseStub
{
    const EVENT_NAME = 'event_name';

    /**
     * @event (name="event_name", methods="post")
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }

}
