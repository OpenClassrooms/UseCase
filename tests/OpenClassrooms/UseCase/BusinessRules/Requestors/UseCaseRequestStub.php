<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\Requestors;

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
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
