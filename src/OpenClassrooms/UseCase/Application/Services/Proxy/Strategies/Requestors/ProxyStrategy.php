<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface ProxyStrategy
{
    const SECURITY = 'security';

    const CACHE = 'cache';

    const TRANSACTION = 'transaction';

    const EVENT = 'event';

    /**
     * @return string
     */
    public function getType();
}
