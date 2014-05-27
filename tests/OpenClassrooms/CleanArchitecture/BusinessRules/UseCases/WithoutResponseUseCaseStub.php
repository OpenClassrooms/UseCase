<?php

namespace OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCase;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class WithoutResponseUseCaseStub implements UseCase
{
    /**
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
    }

}
