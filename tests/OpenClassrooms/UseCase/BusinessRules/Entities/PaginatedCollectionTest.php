<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\Entities;

use OpenClassrooms\UseCase\Application\Entity\PaginatedCollectionImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class PaginatedCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function NewPaginatedCollection_ReturnPaginatedCollection()
    {
        $paginatedCollection = new PaginatedCollectionImpl();
        $this->assertEmpty($paginatedCollection->getItems());
        $this->assertEquals(0, $paginatedCollection->getItemsPerPage());
        $this->assertEquals(1, $paginatedCollection->getPage());
        $this->assertEquals(0, $paginatedCollection->getTotalItems());
        $this->assertEquals(1, $paginatedCollection->getTotalPages());
    }
}
