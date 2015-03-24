<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Event;

use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\UseCase\Application\Annotations\Event;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class MultiEventUseCaseStub extends UseCaseStub
{
    const FIRST_EVENT_NAME = 'use_case.post.first_event';

    const SECOND_EVENT_NAME = 'use_case.post.second_event';

    /**
     * @Event(methods="post", name="first_event")
     * @Event(methods="post", name="second_event")
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }
}
