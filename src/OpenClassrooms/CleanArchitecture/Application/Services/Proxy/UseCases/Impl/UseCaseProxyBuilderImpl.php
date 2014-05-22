<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\Impl;

use OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\UseCaseProxyBuilder;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseProxyBuilderImpl extends UseCaseProxyBuilder
{
    /**
     * @return UseCaseProxyBuilder
     */
    public function create(UseCase $useCase)
    {
        $this->useCaseProxy = new UseCaseProxyImpl();
        $this->useCaseProxy->setUseCase($useCase);

        return $this;
    }
}
