<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Cache;

use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\ExceptionUseCaseStub;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
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
