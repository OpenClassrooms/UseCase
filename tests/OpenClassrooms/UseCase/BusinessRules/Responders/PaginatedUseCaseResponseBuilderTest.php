<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\Responders;

use OpenClassrooms\Tests\UseCase\BusinessRules\Responders\Doubles\PaginatedUseCaseResponseBuilderStub;
use OpenClassrooms\UseCase\BusinessRules\Responders\PaginatedUseCaseResponseBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class PaginatedUseCaseResponseBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PaginatedUseCaseResponseBuilder
     */
    private $builder;

    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\BusinessRules\Responders\Exceptions\InvalidPaginatedUseCaseResponseException
     * @expectedExceptionMessage Items MUST be defined
     */
    public function WithoutItems_ThrowException()
    {
        $this->builder->create()->build();
    }

    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\BusinessRules\Responders\Exceptions\InvalidPaginatedUseCaseResponseException
     * @expectedExceptionMessage  TotalItems MUST be defined
     */
    public function WithoutTotalItems_ThrowException()
    {
        $this->builder->create()->withItems(array())->build();
    }

    /**
     * @test
     */
    public function WithoutItemsPerPage_Build_ReturnResponse()
    {
        $paginatedUseCaseResponse = $this->builder
            ->create()
            ->withItems(array())
            ->withTotalItems(100)
            ->build();
        $this->assertEquals(1, $paginatedUseCaseResponse->getPage());
        $this->assertEquals(1, $paginatedUseCaseResponse->getTotalPages());
    }

    /**
     * @test
     */
    public function WithItemsPerPageAndTotalItems_ReturnResponse()
    {
        $paginatedUseCaseResponse = $this->builder
            ->create()
            ->withItems(array())
            ->withItemsPerPage(10)
            ->withTotalItems(98)
            ->build();

        $this->assertEquals(1, $paginatedUseCaseResponse->getPage());
        $this->assertEquals(10, $paginatedUseCaseResponse->getTotalPages());
    }

    /**
     * @test
     */
    public function WithItemsPerPageSuperiorToTotalItems_ReturnResponse()
    {
        $paginatedUseCaseResponse = $this->builder
            ->create()
            ->withItems(array())
            ->withItemsPerPage(10)
            ->withTotalItems(9)
            ->build();

        $this->assertEquals(1, $paginatedUseCaseResponse->getPage());
        $this->assertEquals(1, $paginatedUseCaseResponse->getTotalPages());
    }

    /**
     * @test
     */
    public function SecondPage_ReturnResponse()
    {
        $paginatedUseCaseResponse = $this->builder
            ->create()
            ->withItems(array())
            ->withItemsPerPage(10)
            ->withFirstItemIndex(10)
            ->withLastItemIndex(19)
            ->withTotalItems(98)
            ->build();

        $this->assertEquals(2, $paginatedUseCaseResponse->getCurrentPage());
    }

    /**
     * @test
     */
    public function LastPage_ReturnResponse()
    {
        $paginatedUseCaseResponse = $this->builder
            ->create()
            ->withItems(array())
            ->withItemsPerPage(10)
            ->withFirstItemIndex(90)
            ->withLastItemIndex(98)
            ->withTotalItems(98)
            ->build();

        $this->assertEquals(10, $paginatedUseCaseResponse->getCurrentPage());
    }

    /**
     * @test
     */
    public function ReturnResponse()
    {
        $paginatedUseCaseResponse = $this->builder
            ->create()
            ->withItems(array())
            ->withItemsPerPage(10)
            ->withFirstItemIndex(90)
            ->withLastItemIndex(98)
            ->withTotalItems(98)
            ->build();

        $this->assertEquals(10, $paginatedUseCaseResponse->getItemsPerPage());
        $this->assertEquals(90, $paginatedUseCaseResponse->getFirstItemIndex());
        $this->assertEquals(98, $paginatedUseCaseResponse->getLastItemIndex());
    }


    protected function setUp()
    {
        $this->builder = new PaginatedUseCaseResponseBuilderStub();
    }
}
