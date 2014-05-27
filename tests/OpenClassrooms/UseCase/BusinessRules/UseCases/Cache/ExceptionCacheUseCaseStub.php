<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Cache;

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\ExceptionUseCaseStub;
use OpenClassrooms\UseCase\Application\Annotations\Cache;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ExceptionCacheUseCaseStub extends ExceptionUseCaseStub
{
    /**
     * @cache
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }

}
