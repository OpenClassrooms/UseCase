<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Cache;

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\UseCase\Application\Annotations\Cache;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
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
