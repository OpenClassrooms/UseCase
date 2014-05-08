<?php

namespace OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\Cache;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\ExceptionUseCaseStub;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Cache;

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
