<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Transaction;

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\ExceptionUseCaseStub;
use OpenClassrooms\UseCase\Application\Annotations\Transaction;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
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
