<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\Requestors;

use OpenClassrooms\CleanArchitecture\BusinessRules\Exceptions\UseCaseIsNotDefineException;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class UseCaseProxyBuilder
{
    /**
     * @var UseCaseProxy
     */
    protected $useCaseProxy;

    /**
     * @return UseCaseProxyBuilder
     */
    public function forUseCase(UseCase $useCase)
    {
        $this->useCaseProxy->setUseCase($useCase);

        return $this;
    }

    /**
     * @return UseCaseProxy
     * @throws \OpenClassrooms\CleanArchitecture\BusinessRules\Exceptions\UseCaseIsNotDefineException
     */
    public function build()
    {
        if (null === $this->useCaseProxy->getUseCase()) {
            throw new UseCaseIsNotDefineException();
        }

        return $this->useCaseProxy;
    }
}
