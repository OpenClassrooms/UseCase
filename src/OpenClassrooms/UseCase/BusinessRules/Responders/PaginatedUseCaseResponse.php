<?php

namespace OpenClassrooms\UseCase\BusinessRules\Responders;

/**
 * @author Kévin Letord <kevin.letord@simple-it.fr>
 */
abstract class PaginatedUseCaseResponse implements UseCaseResponse
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
    protected $itemsPerPage;

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
    public function getCurrentPage()
    {
        if (null !== $this->itemsPerPage) {
            $currentPage = floor($this->firstItemIndex / $this->itemsPerPage) + 1;
        } else {
            $currentPage = 1;
        }

        return $currentPage;
    }

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
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
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
    public function getTotalPages()
    {
        if (null !== $this->totalItems && null !== $this->itemsPerPage) {
            $totalPages = ceil($this->totalItems / $this->itemsPerPage);
        } else {
            $totalPages = 1;
        }

        return $totalPages;
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
