<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Workflow;

use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class AllAnnotationsNotAuthorizedUseCaseStub extends UseCaseStub
{
    /**
     * @event (name="event_name", methods="pre, post, onException")
     * @transaction
     * @cache
     * @security (roles = "ROLE_NOT_AUTHORIZED")
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }
}
