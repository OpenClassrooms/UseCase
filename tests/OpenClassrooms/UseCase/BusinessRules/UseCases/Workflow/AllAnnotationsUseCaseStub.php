<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Workflow;

use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\UseCase\Application\Annotations\Cache;
use OpenClassrooms\UseCase\Application\Annotations\Event;
use OpenClassrooms\UseCase\Application\Annotations\Log;
use OpenClassrooms\UseCase\Application\Annotations\Security;
use OpenClassrooms\UseCase\Application\Annotations\Transaction;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;
use Psr\Log\LogLevel;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class AllAnnotationsUseCaseStub extends UseCaseStub
{
    const PRE_LEVEL = LogLevel::DEBUG;

    const POST_LEVEL = LogLevel::INFO;

    const ON_EXCEPTION_LEVEL = LogLevel::ERROR;

    /**
     * @Event (name="event_name", methods="pre, post, onException")
     * @Transaction
     * @Cache
     * @Security (roles = "ROLE_1")
     * @Log (methods="pre", level="debug")
     * @Log (methods="post", level="info")
     * @Log (methods="onException", level="error")
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }
}
