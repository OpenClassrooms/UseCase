<?php

namespace OpenClassrooms\UseCase\BusinessRules\Entities;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class PaginatedCollectionBuilder
{
    /**
     * @var PaginatedCollection
     */
    protected $paginatedCollection;

    /**
     * @return PaginatedCollectionBuilder
     * @codeCoverageIgnore
     */
    abstract public function create();

    /**
     * @return PaginatedCollectionBuilder
     */
    public function withFirstItemIndex($firstItemIndex)
    {
        $this->paginatedCollection->setFirstItemIndex($firstItemIndex);

        return $this;
    }

    /**
     * @return PaginatedCollectionBuilder
     */
    public function withItems(array $items)
    {
        $this->paginatedCollection->setItems($items);

        return $this;
    }

    /**
     * @return PaginatedCollectionBuilder
     */
    public function withLastItemIndex($lastItemIndex)
    {
        $this->paginatedCollection->setLastItemIndex($lastItemIndex);

        return $this;
    }

    /**
     * @return PaginatedCollectionBuilder
     */
    public function withTotalItems($totalItems)
    {
        $this->paginatedCollection->setTotalItems($totalItems);

        return $this;
    }

    /**
     * @return PaginatedCollection
     */
    public function build()
    {
        return $this->paginatedCollection;
    }
}
