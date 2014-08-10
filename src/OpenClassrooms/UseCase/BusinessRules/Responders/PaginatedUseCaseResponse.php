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
    protected $currentPage = 1;

    /**
     * @var integer
     */
    protected $totalPages = 1;

    /**
     * @var integer
     */
    protected $firstItemIndex;

    /**
     * @var integer
     */
    protected $lastItemIndex;

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function setFirstItemIndex($firstItemIndex)
    {
        $this->firstItemIndex = $firstItemIndex;
    }

    /**
     * @return int
     */
    public function getFirstItemIndex()
    {
        return $this->firstItemIndex;
    }

    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    public function setLastItemIndex($lastItemIndex)
    {
        $this->lastItemIndex = $lastItemIndex;
    }

    /**
     * @return int
     */
    public function getLastItemIndex()
    {
        return $this->lastItemIndex;
    }

    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;
    }

    /**
     * @return int
     */
    public function getTotalItems()
    {
        return $this->totalItems;
    }

    /**
     * @return int
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }
}
