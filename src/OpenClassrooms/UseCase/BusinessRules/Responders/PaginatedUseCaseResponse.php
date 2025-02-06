<?php

namespace OpenClassrooms\UseCase\BusinessRules\Responders;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 * @author Kévin Letord <kevin.letord@openclassrooms.com>
 * @deprecated
 */
interface PaginatedUseCaseResponse extends UseCaseResponse, \IteratorAggregate
{
    /**
     * @return array
     */
    public function getItems();

    /**
     * @return int
     */
    public function getItemsPerPage();

    public function getIterator(): \Traversable;

    /**
     * @return int
     */
    public function getPage();

    /**
     * @return int
     */
    public function getTotalItems();

    /**
     * @return int
     */
    public function getTotalPages();


}
