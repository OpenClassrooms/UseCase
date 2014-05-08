<?php

namespace OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\Event;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Event;

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
