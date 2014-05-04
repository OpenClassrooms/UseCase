<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\Exceptions\UseCaseIsNotDefineException;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCase;

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
     * @throws UseCaseIsNotDefineException
     */
    public function build()
    {
        if (null === $this->useCaseProxy->getUseCase()) {
            throw new UseCaseIsNotDefineException();
        }

        return $this->useCaseProxy;
    }
}
