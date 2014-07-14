<?php

namespace OpenClassrooms\UseCase\Application\Services\Security;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface Security
{
    /**
     * @throws \Exception
     */
    public function checkAccess($attributes, $object = null);
}
