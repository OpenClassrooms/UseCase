<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\Impl;

use OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\UseCaseProxyBuilder;

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
