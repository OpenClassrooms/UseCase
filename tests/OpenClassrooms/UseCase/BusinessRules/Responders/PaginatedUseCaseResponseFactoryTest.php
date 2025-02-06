<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\Responders;

use OpenClassrooms\Tests\UseCase\BusinessRules\Responders\Doubles\PaginatedUseCaseResponseBuilderStub;
use OpenClassrooms\UseCase\Application\Entity\PaginatedCollectionImpl;
use OpenClassrooms\UseCase\Application\Responder\PaginatedUseCaseResponseFactoryImpl;
use OpenClassrooms\UseCase\BusinessRules\Responders\PaginatedUseCaseResponseFactory;
use PHPUnit\Framework\TestCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class PaginatedUseCaseResponseFactoryTest extends TestCase
{

    /**
     * @var PaginatedUseCaseResponseFactory
     */
    private $factory;

    /**
     * @test
     */
    public function WithEmptyPaginatedCollection_CreateFromPaginatedCollection_ReturnResponse()
    {
        $response = $this->factory->createFromPaginatedCollection(new PaginatedCollectionImpl());

        $this->assertEmpty($response->getItems());
        $this->assertEquals(0, $response->getItemsPerPage());
        $this->assertEquals(1, $response->getPage());
        $this->assertEquals(0, $response->getTotalItems());
        $this->assertEquals(1, $response->getTotalPages());
    }

    /**
     * @test
     */
    public function WithPaginatedCollection_CreateFromPaginatedCollection_ReturnResponse()
    {
        $expectedItems = array('item1', 'item2', 'item3');
        $expectedItemsPerPage = 2;
        $expectedPage = 2;
        $paginatedCollection = new PaginatedCollectionImpl();
        $paginatedCollection->setItems($expectedItems);
        $paginatedCollection->setItemsPerPage($expectedItemsPerPage);
        $paginatedCollection->setPage($expectedPage);
        $paginatedCollection->setTotalItems(count($expectedItems));

        $response = $this->factory->createFromPaginatedCollection($paginatedCollection);

        $this->assertEquals($expectedItems, $response->getItems());
        $this->assertEquals($expectedItemsPerPage, $response->getItemsPerPage());
        $this->assertEquals($expectedPage, $response->getPage());
        $this->assertEquals(count($expectedItems), $response->getTotalItems());
        $this->assertEquals(2, $response->getTotalPages());
    }

    protected function setUp(): void
    {
        $this->factory = new PaginatedUseCaseResponseFactoryImpl();
        $this->factory->setPaginatedUseCaseResponseBuilder(new PaginatedUseCaseResponseBuilderStub());
    }
}
