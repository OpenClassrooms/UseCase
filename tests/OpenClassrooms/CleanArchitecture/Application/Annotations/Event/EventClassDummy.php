<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Annotations\Event;

use OpenClassrooms\CleanArchitecture\Application\Annotations\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class EventClassDummy
{
    /**
     * @event
     */
    public function withoutName()
    {

    }

    /**
     * @event (name="event_name", methods="invalid method")
     */
    public function invalidMethod()
    {

    }
}
