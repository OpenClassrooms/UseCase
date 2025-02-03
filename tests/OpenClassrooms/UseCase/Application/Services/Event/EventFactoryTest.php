<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Event;

use OpenClassrooms\UseCase\Application\Services\Event\Exceptions\InvalidEventNameException;
use PHPUnit\Framework\TestCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function InvalidEventName_Make_ThrowException()
    {
        $factory = new EventFactorySpy();

        $this->expectException(InvalidEventNameException::class);
        $factory->make(EventFactorySpy::INVALID_EVENT_NAME);
    }
}
