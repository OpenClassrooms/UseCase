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
    const EVENT_NAME = 'post_event_use_case_stub';

    /**
     * @event (methods="post")
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }

}
