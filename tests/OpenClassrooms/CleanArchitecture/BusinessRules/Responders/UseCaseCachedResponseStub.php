<?php

namespace OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Responders;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseCachedResponseStub extends UseCaseResponseStub
{
    const VALUE = 'cached value';

    public $value = self::VALUE;
}
