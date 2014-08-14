<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\Responders\Doubles;

use OpenClassrooms\UseCase\BusinessRules\Responders\PaginatedUseCaseResponseBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class PaginatedUseCaseResponseBuilderStub extends PaginatedUseCaseResponseBuilder
{
    /**
     * @return PaginatedUseCaseResponseBuilder
     */
    public function create()
    {
        $this->paginatedUseCaseResponse = new PaginatedUseCaseResponseStub();

        return $this;
    }
}
