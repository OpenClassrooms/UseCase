<?php

namespace OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Requestors;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseProxyBuilder;
use OpenClassrooms\CleanArchitecture\BusinessRules\UseCases\UseCaseProxyBuilderImpl;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\UseCaseStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseProxyBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UseCaseProxyBuilder
     */
    private $builder;

    /**
     * @test
     * @expectedException \OpenClassrooms\CleanArchitecture\BusinessRules\Exceptions\UseCaseIsNotDefineException
     */
    public function WithoutUseCase_Build_ThrowException()
    {
        $this->builder->build();
    }

    /**
     * @test
     */
    public function Build_ReturnUseCaseProxy()
    {
        $proxy = $this->builder
            ->forUseCase(new UseCaseStub())
            ->build();

        $this->assertInstanceOf(
            '\OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseProxy',
            $proxy
        );
        $this->assertEquals(new UseCaseStub(), $proxy->getUseCase());
    }

    protected function setUp()
    {
        $this->builder = new UseCaseProxyBuilderImpl();
    }

}
