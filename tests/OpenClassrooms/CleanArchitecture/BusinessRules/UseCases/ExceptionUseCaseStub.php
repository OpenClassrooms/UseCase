<?php

namespace OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCase;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Exceptions\UseCaseException;
use OpenClassrooms\CleanArchitecture\Annotations\Cache;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ExceptionUseCaseStub implements UseCase
{
    /**
     * @cache
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        throw new UseCaseException();
    }

}
