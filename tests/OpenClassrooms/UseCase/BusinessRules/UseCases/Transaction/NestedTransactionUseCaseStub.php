<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Transaction;

use OpenClassrooms\UseCase\Application\Annotations\Transaction;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class NestedTransactionUseCaseStub implements UseCase
{
    /**
     * @var UseCase
     */
    private $nestedUseCase;

    /**
     * @Transaction()
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return $this->nestedUseCase->execute($useCaseRequest);
    }

    public function setNestedUseCase(UseCase $nestedUseCase)
    {
        $this->nestedUseCase = $nestedUseCase;
    }
}
