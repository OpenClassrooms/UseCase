<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Impl;

use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxyBuilder;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;

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
