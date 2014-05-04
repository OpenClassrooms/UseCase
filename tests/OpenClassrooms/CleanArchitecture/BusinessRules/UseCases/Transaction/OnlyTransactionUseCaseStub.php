<?php

namespace OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\Transaction;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCase;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Responders\UseCaseResponseStub;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Transaction;
/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OnlyTransactionUseCaseStub implements UseCase
{
    /**
     * @transaction
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return new UseCaseResponseStub();
    }

}
