<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\Responders;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class UseCaseCachedResponseStub extends UseCaseResponseStub
{
    const VALUE = 'cached value';

    public $value = self::VALUE;
}
