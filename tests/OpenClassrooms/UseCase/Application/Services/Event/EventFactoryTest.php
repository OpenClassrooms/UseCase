<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Event\Exceptions\InvalidEventNameException
     */
    public function InvalidEventName_Make_ThrowException()
    {
        $factory = new EventFactorySpy();
        $factory->make(EventFactorySpy::INVALID_EVENT_NAME);
    }
}
