<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Transaction;

use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\ExceptionUseCaseStub;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class ExceptionTransactionUseCaseStub extends ExceptionUseCaseStub
{
    /**
     * @transaction
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }

}
