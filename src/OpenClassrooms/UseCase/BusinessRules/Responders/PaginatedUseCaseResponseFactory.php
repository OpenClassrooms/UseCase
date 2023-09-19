<?php

namespace OpenClassrooms\UseCase\BusinessRules\Responders;

use OpenClassrooms\UseCase\BusinessRules\Entities\PaginatedCollection;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 * @deprecated
 */
interface PaginatedUseCaseResponseFactory
{
    /**
     * @return AbstractPaginatedUseCaseResponse
     */
    public function createFromPaginatedCollection(PaginatedCollection $paginatedCollection);
}
