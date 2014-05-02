<?php

namespace OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCase;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Responders\UseCaseResponseStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseStub implements UseCase
{
    /**
     * @return UseCaseResponse
     * @api
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return new UseCaseResponseStub();
    }

}
