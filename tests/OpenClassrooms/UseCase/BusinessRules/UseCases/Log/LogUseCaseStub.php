<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Log;

use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\ExceptionUseCaseStub;
use OpenClassrooms\UseCase\Application\Annotations\Log;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class LogUseCaseStub extends ExceptionUseCaseStub
{
    /**
     * @Log (message="message with context {foo}", context={"foo":"bar"})
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }
}
