<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Workflow;

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\UseCase\Application\Annotations\Security;
use OpenClassrooms\UseCase\Application\Annotations\Cache;
use OpenClassrooms\UseCase\Application\Annotations\Transaction;
use OpenClassrooms\UseCase\Application\Annotations\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class AllAnnotationsUseCaseStub extends UseCaseStub
{
    /**
     * @event (name="event_name", methods="pre, post, onException")
     * @transaction
     * @cache
     * @security (roles = "ROLE_1")
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }
}
