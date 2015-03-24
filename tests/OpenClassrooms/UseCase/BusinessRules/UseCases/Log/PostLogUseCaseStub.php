<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Log;

use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\UseCase\Application\Annotations\Log;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class PostLogUseCaseStub extends UseCaseStub
{
    const MESSAGE = 'Post Message';

    /**
     * @Log (methods="post", message="Post Message")
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }
}
