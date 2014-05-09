<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Services\Proxy\UseCases;

use Doctrine\Common\Annotations\AnnotationReader;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\Impl\UseCaseProxyBuilderImpl;
use OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\UseCaseProxyBuilder;
use OpenClassrooms\Tests\CleanArchitecture\Application\Services\Cache\CacheSpy;
use OpenClassrooms\Tests\CleanArchitecture\Application\Services\Event\EventFactorySpy;
use OpenClassrooms\Tests\CleanArchitecture\Application\Services\Event\EventSpy;
use OpenClassrooms\Tests\CleanArchitecture\Application\Services\Security\SecuritySpy;
use OpenClassrooms\Tests\CleanArchitecture\Application\Services\Transaction\TransactionSpy;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Requestors\UseCaseRequestStub;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Responders\UseCaseResponseStub;
use
    OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\Workflow\AllAnnotationsUseCaseStub;

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
     * @expectedException \OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\Exceptions\ReaderIsNotDefinedException
     */
    public function WithoutReader_Build_ThrowException()
    {
        $this->builder->forUseCase(new AllAnnotationsUseCaseStub())->build();
    }

    /**
     * @test
     */
    public function Build_ReturnUseCaseProxy()
    {
        $proxy = $this->builder
            ->forUseCase(new AllAnnotationsUseCaseStub())
            ->withReader(new AnnotationReader())
            ->withCache(new CacheSpy())
            ->withEvent(new EventSpy())
            ->withEventFactory(new EventFactorySpy())
            ->withSecurity(new SecuritySpy())
            ->withTransaction(new TransactionSpy())
            ->build();

        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $proxy);
        $this->assertEquals(new AllAnnotationsUseCaseStub(), $proxy->getUseCase());
        $this->assertEquals(new UseCaseResponseStub(), $proxy->execute(new UseCaseRequestStub()));
    }

    protected function setUp()
    {
        $this->builder = new UseCaseProxyBuilderImpl();
    }

}
