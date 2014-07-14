<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Security;

use OpenClassrooms\UseCase\Application\Services\Security\Security;
use
    OpenClassrooms\Tests\UseCase\Application\Services\Security\Exceptions\AccessDeniedException;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
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
