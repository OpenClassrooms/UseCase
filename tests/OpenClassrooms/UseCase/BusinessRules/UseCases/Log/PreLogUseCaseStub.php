<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Log;

use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\UseCase\Application\Annotations\Log;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class PreLogUseCaseStub extends UseCaseStub
{
    const MESSAGE = 'Pre Message';

    /**
     * @Log (methods="pre", message="Pre Message")
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }
}
