<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\UseCases;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseProxyBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseProxyBuilderImpl extends UseCaseProxyBuilder
{

    public function __construct()
    {
        $this->useCaseProxy = new UseCaseProxyImpl();
    }
}
