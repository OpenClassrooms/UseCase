<?php

namespace OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\Cache;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Cache;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class LifeTimeCacheUseCaseStub extends UseCaseStub
{
    const LIFETIME = 100;

    /**
     * @Cache (lifetime = 100)
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }
}
