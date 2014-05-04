<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Services\Proxy\UseCases;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\Impl\UseCaseProxyBuilderImpl;
use OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\UseCaseProxyBuilder;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\UseCaseStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseProxyBuilderTest extends \PHPUnit_Framework_TestCase
{
    const USE_CASE_PROXY_CLASS = 'OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\UseCaseProxy';

    /**
     * @var UseCaseProxyBuilder
     */
    private $builder;

    /**
     * @test
     * @expectedException \OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\Exceptions\UseCaseIsNotDefineException
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
            self::USE_CASE_PROXY_CLASS,
            $proxy
        );
        $this->assertEquals(new UseCaseStub(), $proxy->getUseCase());
    }

    protected function setUp()
    {
        $this->builder = new UseCaseProxyBuilderImpl();
    }

}
