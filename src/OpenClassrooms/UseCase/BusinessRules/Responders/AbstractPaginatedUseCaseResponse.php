<?php

namespace OpenClassrooms\UseCase\BusinessRules\Responders;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
abstract class AbstractPaginatedUseCaseResponse implements PaginatedUseCaseResponse
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
    protected $page;

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    public function setPage($page)
    {
        $this->page = $page;
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
