<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\Responders;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseCachedResponseStub extends UseCaseResponseStub
{
    const VALUE = 'cached value';

    public $value = self::VALUE;
}
