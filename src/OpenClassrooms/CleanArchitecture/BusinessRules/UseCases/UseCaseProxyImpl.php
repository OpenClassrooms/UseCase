<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\UseCases;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCase;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseProxy;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Responders\UseCaseResponseStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseProxyImpl extends UseCaseProxy
{
    /**
     * @var UseCase
     */
    private $useCase;

    public function __construct(UseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return new UseCaseResponseStub();
    }
}
