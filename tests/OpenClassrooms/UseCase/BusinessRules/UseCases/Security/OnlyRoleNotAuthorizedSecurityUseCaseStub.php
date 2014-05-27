<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Security;

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\UseCase\Application\Annotations\Security;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OnlyRoleNotAuthorizedSecurityUseCaseStub extends UseCaseStub
{
    /**
     * @security (roles = "ROLE_NOT_AUTHORIZED")
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }
}
