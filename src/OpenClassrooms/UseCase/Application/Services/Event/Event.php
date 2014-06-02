<?php

namespace OpenClassrooms\UseCase\Application\Services\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface Event
{
    public function send($eventName, $event);
}
