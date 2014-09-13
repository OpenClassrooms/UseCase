<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Log;

use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\UseCase\Application\Annotations\Log;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use Psr\Log\LogLevel;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class MultiLogUseCaseStub extends UseCaseStub
{
    const PRE_LEVEL = LogLevel::DEBUG;

    const PRE_MESSAGE = 'Pre Message';

    const POST_LEVEL = LogLevel::INFO;

    const POST_MESSAGE = 'Post Message';

    /**
     * @var string[]
     */
    public static $preContext = array('pre' => 'context-pre-value');

    /**
     * @var string[]
     */
    public static $postContext = array('post' => 'context-post-value');

    /**
     * @Log (methods="pre", level="debug", message="Pre Message", context={"pre":"context-pre-value"})
     * @Log (methods="post", level="info", message="Post Message", context={"post":"context-post-value"})
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }

}
