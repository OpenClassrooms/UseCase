<?php

namespace OpenClassrooms\UseCase\BusinessRules\Responders;

use OpenClassrooms\UseCase\BusinessRules\Responders\Exceptions\InvalidPaginatedUseCaseResponseException;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class PaginatedUseCaseResponseBuilder
{
    /**
     * @var AbstractPaginatedUseCaseResponse
     */
    protected $paginatedUseCaseResponse;

    /**
     * @return PaginatedUseCaseResponseBuilder
     * @codeCoverageIgnore
     */
    abstract public function create();

    /**
     * @return PaginatedUseCaseResponseBuilder
     */
    public function withFirstItemIndex($firstItemIndex)
    {
        $this->paginatedUseCaseResponse->setFirstItemIndex($firstItemIndex);

        return $this;
    }

    /**
     * @return PaginatedUseCaseResponseBuilder
     */
    public function withItems(array $items)
    {
        $this->paginatedUseCaseResponse->setItems($items);

        return $this;
    }

    /**
     * @return PaginatedUseCaseResponseBuilder
     */
    public function withItemsPerPage($itemsPerPage)
    {
        $this->paginatedUseCaseResponse->setItemsPerPage($itemsPerPage);

        return $this;
    }

    /**
     * @return PaginatedUseCaseResponseBuilder
     */
    public function withLastItemIndex($lastItemIndex)
    {
        $this->paginatedUseCaseResponse->setLastItemIndex($lastItemIndex);

        return $this;
    }

    /**
     * @return PaginatedUseCaseResponseBuilder
     */
    public function withTotalItems($totalItems)
    {
        $this->paginatedUseCaseResponse->setTotalItems($totalItems);

        return $this;
    }

    /**
     * @return AbstractPaginatedUseCaseResponse
     */
    public function build()
    {
        if (null === $this->paginatedUseCaseResponse->getItems()) {
            throw new InvalidPaginatedUseCaseResponseException('Items MUST be defined');
        }

        if (null === $this->paginatedUseCaseResponse->getTotalItems()) {
            throw new InvalidPaginatedUseCaseResponseException('TotalItems MUST be defined');
        }
        return $this->paginatedUseCaseResponse;
    }
} 
