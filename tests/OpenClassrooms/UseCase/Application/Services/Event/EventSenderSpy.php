<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Event;

use OpenClassrooms\UseCase\Application\Services\Event\EventSender;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventSenderSpy implements EventSender
{

    /**
     * @var array
     */
    public $events = array();

    public function send($eventName, $event)
    {
        $this->events[$eventName] = $event;
    }
}
