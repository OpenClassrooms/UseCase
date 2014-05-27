<?php

namespace OpenClassrooms\Tests\UseCase\Application\Annotations\Event;

use OpenClassrooms\UseCase\Application\Annotations\Event;

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
