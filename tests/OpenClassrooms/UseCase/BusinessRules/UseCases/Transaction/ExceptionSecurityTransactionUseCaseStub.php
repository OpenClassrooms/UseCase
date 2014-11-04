<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Transaction;

use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\UseCase\Application\Annotations\Security;
use OpenClassrooms\UseCase\Application\Annotations\Transaction;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class ExceptionSecurityTransactionUseCaseStub extends UseCaseStub
{
    /**
     * @Security (roles = "ROLE_NOT_AUTHORIZED")
     * @Transaction
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }

}
