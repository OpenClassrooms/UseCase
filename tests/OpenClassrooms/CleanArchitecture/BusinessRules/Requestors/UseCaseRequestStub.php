<?php

namespace OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Requestors;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseRequestStub implements UseCaseRequest
{
    const FIELD_VALUE = 'field value';

    /**
     * @var string
     */
    private $field = self::FIELD_VALUE;

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }
}
