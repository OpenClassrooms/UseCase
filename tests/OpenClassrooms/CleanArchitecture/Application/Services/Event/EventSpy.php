<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Services\Event;

use OpenClassrooms\CleanArchitecture\Application\Services\Event\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class EventSpy implements Event
{
    /**
     * @var bool
     */
    public $sent = false;

    /**
     * @var int
     */
    public $sentCount = 0;

    /**
     * @var mixed
     */
    public $event;

    public function send($event)
    {
        $this->sent = true;
        $this->sentCount++;
        $this->event = $event;
    }

}
