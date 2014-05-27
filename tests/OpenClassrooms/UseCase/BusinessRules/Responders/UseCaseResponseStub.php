<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\Responders;

use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseResponseStub implements UseCaseResponse
{
    const VALUE = 'value';

    public $value = self::VALUE;
}
