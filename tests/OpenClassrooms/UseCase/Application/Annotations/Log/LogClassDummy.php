<?php

namespace OpenClassrooms\Tests\UseCase\Application\Annotations\Log;

use OpenClassrooms\UseCase\Application\Annotations\Log;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class LogClassDummy
{
    /**
     * @Log(level="invalid level")
     */
    public function invalidLevel()
    {

    }

    /**
     * @Log (methods="invalid method")
     */
    public function invalidMethod()
    {

    }
}
