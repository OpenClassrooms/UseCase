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
     * @var string[]
     */
    public static $context = array('foo' => 'bar');

    /**
     * @Log (methods="pre", message="Pre Message", context= "'foo'=>'bar'")
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }

}
