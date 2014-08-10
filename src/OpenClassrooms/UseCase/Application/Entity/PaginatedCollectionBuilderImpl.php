<?php

namespace OpenClassrooms\UseCase\Application\Entity;

use OpenClassrooms\UseCase\BusinessRules\Entities\PaginatedCollectionBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class PaginatedCollectionBuilderImpl extends PaginatedCollectionBuilder
{
    /**
     * @return PaginatedCollectionBuilder
     */
    public function create()
    {
        $this->paginatedCollection = new PaginatedCollectionImpl();

        return $this;
    }
}
