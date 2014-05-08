<?php

namespace OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\Transaction;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\ExceptionUseCaseStub;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Transaction;

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
