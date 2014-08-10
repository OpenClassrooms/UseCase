<?php

namespace OpenClassrooms\UseCase\BusinessRules\Entities;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class PaginatedCollection
{
    /**
     * @var array
     */
    protected $items;

    /**
     * @var integer
     */
    protected $totalItems;

    /**
     * @var integer
     */
    protected $firstItemIndex = 1;

    /**
     * @var integer
     */
    protected $lastItemIndex;

    /**
     * @return int
     */
    public function getFirstItemIndex()
    {
        return $this->firstItemIndex;
    }

    public function setFirstItemIndex($firstItemIndex)
    {
        $this->firstItemIndex = $firstItemIndex;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return int
     */
    public function getLastItemIndex()
    {
        return $this->lastItemIndex;
    }

    public function setLastItemIndex($lastItemIndex)
    {
        $this->lastItemIndex = $lastItemIndex;
    }

    /**
     * @return int
     */
    public function getTotalItems()
    {
        return $this->totalItems;
    }

    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;
    }

}
