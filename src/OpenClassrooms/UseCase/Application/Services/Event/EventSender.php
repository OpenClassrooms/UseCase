<?php

namespace OpenClassrooms\UseCase\Application\Services\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface EventSender
{
    public function send($eventName, $event);
}
