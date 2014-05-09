<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Services\Security;

use OpenClassrooms\CleanArchitecture\Application\Services\Security\Security;
use
    OpenClassrooms\Tests\CleanArchitecture\Application\Services\Security\Exceptions\AccessDeniedException;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class SecuritySpy implements Security
{
    /**
     * @var array
     */
    public $attributes;

    /**
     * @var mixed
     */
    public $object;

    public function checkAccess($attributes, $object = null)
    {
        $this->attributes = $attributes;
        $this->object = $object;

        if (!in_array('ROLE_1', $attributes)) {
            throw new AccessDeniedException();
        }
    }
}
