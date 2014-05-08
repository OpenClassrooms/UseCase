<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Services\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class EventFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \OpenClassrooms\CleanArchitecture\Application\Services\Event\Exceptions\InvalidEventNameException
     */
    public function InvalidEventName_Make_ThrowException()
    {
        $factory = new EventFactorySpy();
        $factory->make(EventFactorySpy::INVALID_EVENT_NAME);
    }
}
