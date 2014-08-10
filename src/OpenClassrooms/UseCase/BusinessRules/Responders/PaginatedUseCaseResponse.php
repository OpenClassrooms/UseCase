<?php

namespace OpenClassrooms\UseCase\BusinessRules\Responders;

/**
 * @author Kévin Letord <kevin.letord@simple-it.fr>
 */
interface PaginatedUseCaseResponse
{
    /**
     * @return int
     */
    public function getCurrentPage();

    /**
     * @return int
     */
    public function getFirstItemIndex();

    /**
     * @return array
     */
    public function getItems();

    /**
     * @return int
     */
    public function getItemsPerPage();

    /**
     * @return int
     */
    public function getLastItemIndex();

    /**
     * @return int
     */
    public function getTotalPages();

    /**
     * @return int
     */
    public function getTotalItems();

}
