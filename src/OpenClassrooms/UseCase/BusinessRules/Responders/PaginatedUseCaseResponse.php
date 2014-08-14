<?php

namespace OpenClassrooms\UseCase\BusinessRules\Responders;

/**
 * @author Kévin Letord <kevin.letord@simple-it.fr>
 */
interface PaginatedUseCaseResponse extends UseCaseResponse
{
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
