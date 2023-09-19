<?php

namespace OpenClassrooms\UseCase\Application\Responder;

use OpenClassrooms\UseCase\BusinessRules\Responders\PaginatedUseCaseResponseBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 * @deprecated
 */
class PaginatedUseCaseResponseBuilderImpl extends PaginatedUseCaseResponseBuilder
{
    /**
     * @return PaginatedUseCaseResponseBuilder
     * @codeCoverageIgnore
     */
    public function create()
    {
        $this->paginatedUseCaseResponse = new PaginatedUseCaseResponseImpl();

        return $this;
    }
}
