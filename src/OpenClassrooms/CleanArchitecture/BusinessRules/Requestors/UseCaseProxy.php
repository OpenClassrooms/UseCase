<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\Requestors;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class UseCaseProxy implements UseCase
{
    /**
     * @var UseCase
     */
    protected $useCase;

    /**
     * @return \OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return $this->useCase->execute($useCaseRequest);
    }

    /**
     * @return \OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCase
     */
    public function getUseCase()
    {
        return $this->useCase;
    }

    public function setUseCase(UseCase $useCase)
    {
        $this->useCase = $useCase;
    }
}
