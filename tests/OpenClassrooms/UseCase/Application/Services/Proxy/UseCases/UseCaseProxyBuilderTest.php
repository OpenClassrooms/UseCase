<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Proxy\UseCases;

use Doctrine\Common\Annotations\AnnotationReader;
use
    OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Impl\UseCaseProxyBuilderImpl;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxyBuilder;
use OpenClassrooms\Tests\UseCase\Application\Services\Cache\CacheSpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Event\EventFactorySpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Event\EventSpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Security\SecuritySpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Transaction\TransactionSpy;
use OpenClassrooms\Tests\UseCase\BusinessRules\Requestors\UseCaseRequestStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\Responders\UseCaseResponseStub;
use
    OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Workflow\AllAnnotationsUseCaseStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseProxyBuilderTest extends \PHPUnit_Framework_TestCase
{
    const USE_CASE_PROXY_CLASS = 'OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxy';

    /**
     * @var UseCaseProxyBuilder
     */
    private $builder;

    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\ReaderIsNotDefinedException
     */
    public function WithoutReader_Build_ThrowException()
    {
        $this->builder->create(new AllAnnotationsUseCaseStub())->build();
    }

    /**
     * @test
     */
    public function Build_ReturnUseCaseProxy()
    {
        $proxy = $this->builder
            ->create(new AllAnnotationsUseCaseStub())
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
