<?php

namespace OpenClassrooms\UseCase\Application\Services\Event\Exceptions;

use Exception;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class InvalidEventNameException extends \Exception
{
    public function __construct($eventName)
    {
        return parent::__construct($eventName);
    }
}
