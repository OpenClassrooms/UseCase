<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface Event
{
    public function send($event);
}
