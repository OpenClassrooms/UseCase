<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Security;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface Security
{
    /**
     * @throws \Exception
     */
    public function checkAccess($attributes, $object = null);
}
