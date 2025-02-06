<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Proxy\UseCases;

use Doctrine\Common\Annotations\AnnotationReader;
use OpenClassrooms\Tests\UseCase\Application\Services\Event\EventFactorySpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Event\EventSenderSpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Log\LoggerSpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Security\SecuritySpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Transaction\TransactionSpy;
use OpenClassrooms\Tests\UseCase\BusinessRules\Requestors\UseCaseRequestStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\Responders\Doubles\UseCaseResponseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Cache\OnlyCacheUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Event\OnlyEventNameEventUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Log\OnlyLogUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Security\OnlyRoleSecurityUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Transaction\OnlyTransactionUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Workflow\AllAnnotationsUseCaseStub;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\CacheIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\EventFactoryIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\EventIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\LoggerIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\ReaderIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\SecurityIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\TransactionIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Impl\UseCaseProxyBuilderImpl;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxyBuilder;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class UseCaseProxyBuilderTest extends TestCase
{
    const USE_CASE_PROXY_CLASS = 'OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxy';

    /**
     * @var UseCaseProxyBuilder
     */
    private $builder;

    /**
     * @test
     */
    public function WithoutReader_Build_ThrowException()
    {
        $this->expectException(ReaderIsNotDefinedException::class);

        $this->builder->create(new AllAnnotationsUseCaseStub())->build();
    }

    /**
     * @test
     */
    public function WithoutCacheUseCaseWithCacheAnnotation_Build_ThrowException()
    {
        $this->expectException(CacheIsNotDefinedException::class);

        $this->builder
            ->create(new OnlyCacheUseCaseStub())
            ->withReader(new AnnotationReader())
            ->build();
    }

    /**
     * @test
     */
    public function WithCacheUseCaseWithCacheAnnotation_Build_ReturnUseCaseProxy()
    {
        $proxy = $this->builder
            ->create(new OnlyCacheUseCaseStub())
            ->withReader(new AnnotationReader())
            ->withCache(new ArrayAdapter())
            ->build();

        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $proxy);
        $this->assertEquals(new OnlyCacheUseCaseStub(), $proxy->getUseCase());
        $this->assertEquals(new UseCaseResponseStub(), $proxy->execute(new UseCaseRequestStub()));
    }

    /**
     * @test
     */
    public function WithoutEventUseCaseWithEventAnnotation_Build_ThrowException()
    {
        $this->expectException(EventIsNotDefinedException::class);

        $this->builder
            ->create(new OnlyEventNameEventUseCaseStub())
            ->withReader(new AnnotationReader())
            ->build();
    }

    /**
     * @test
     */
    public function WithoutEventFactoryUseCaseWithEventAnnotation_Build_ThrowException()
    {
        $this->expectException(EventFactoryIsNotDefinedException::class);

        $this->builder
            ->create(new OnlyEventNameEventUseCaseStub())
            ->withReader(new AnnotationReader())
            ->withEventSender(new EventSenderSpy())
            ->build();
    }

    /**
     * @test
     */
    public function WithEventUseCaseWithEventAnnotation_Build_ReturnUseCaseProxy()
    {
        $proxy = $this->builder
            ->create(new OnlyEventNameEventUseCaseStub())
            ->withReader(new AnnotationReader())
            ->withEventSender(new EventSenderSpy())
            ->withEventFactory(new EventFactorySpy())
            ->build();

        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $proxy);
        $this->assertEquals(new OnlyEventNameEventUseCaseStub(), $proxy->getUseCase());
        $this->assertEquals(new UseCaseResponseStub(), $proxy->execute(new UseCaseRequestStub()));
    }

    /**
     * @test
     */
    public function WithoutLoggerUseCaseWithLogAnnotation_Build_ThrowException()
    {
        $this->expectException(LoggerIsNotDefinedException::class);

        $this->builder
            ->create(new OnlyLogUseCaseStub())
            ->withReader(new AnnotationReader())
            ->build();
    }

    /**
     * @test
     */
    public function WithLogUseCaseWithLogAnnotation_Build_ReturnUseCaseProxy()
    {
        $proxy = $this->builder
            ->create(new OnlyLogUseCaseStub())
            ->withReader(new AnnotationReader())
            ->withLogger(new LoggerSpy())
            ->build();

        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $proxy);
        $this->assertEquals(new OnlyLogUseCaseStub(), $proxy->getUseCase());
        $this->assertEquals(new UseCaseResponseStub(), $proxy->execute(new UseCaseRequestStub()));
    }

    /**
     * @test
     */
    public function WithoutSecurityUseCaseWithSecurityAnnotation_Build_ThrowException()
    {
        $this->expectException(SecurityIsNotDefinedException::class);

        $this->builder
            ->create(new OnlyRoleSecurityUseCaseStub())
            ->withReader(new AnnotationReader())
            ->build();
    }

    /**
     * @test
     */
    public function WithSecurityUseCaseWithSecurityAnnotation_Build_ReturnUseCaseProxy()
    {
        $proxy = $this->builder
            ->create(new OnlyRoleSecurityUseCaseStub())
            ->withReader(new AnnotationReader())
            ->withSecurity(new SecuritySpy())
            ->build();

        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $proxy);
        $this->assertEquals(new OnlyRoleSecurityUseCaseStub(), $proxy->getUseCase());
        $this->assertEquals(new UseCaseResponseStub(), $proxy->execute(new UseCaseRequestStub()));
    }

    /**
     * @test
     */
    public function WithoutTransactionUseCaseWithTransactionAnnotation_Build_ThrowException()
    {
        $this->expectException(TransactionIsNotDefinedException::class);

        $this->builder
            ->create(new OnlyTransactionUseCaseStub())
            ->withReader(new AnnotationReader())
            ->build();
    }

    /**
     * @test
     */
    public function WithTransactionUseCaseWithTransactionAnnotation_Build_ReturnUseCaseProxy()
    {
        $proxy = $this->builder
            ->create(new OnlyTransactionUseCaseStub())
            ->withReader(new AnnotationReader())
            ->withTransaction(new TransactionSpy())
            ->build();

        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $proxy);
        $this->assertEquals(new OnlyTransactionUseCaseStub(), $proxy->getUseCase());
        $this->assertEquals(new UseCaseResponseStub(), $proxy->execute(new UseCaseRequestStub()));
    }

    /**
     * @test
     */
    public function Build_ReturnUseCaseProxy()
    {
        $proxy = $this->builder
            ->create(new AllAnnotationsUseCaseStub())
            ->withReader(new AnnotationReader())
            ->withCache(new ArrayAdapter())
            ->withEventSender(new EventSenderSpy())
            ->withEventFactory(new EventFactorySpy())
            ->withLogger(new LoggerSpy())
            ->withSecurity(new SecuritySpy())
            ->withTransaction(new TransactionSpy())
            ->build();

        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $proxy);
        $this->assertEquals(new AllAnnotationsUseCaseStub(), $proxy->getUseCase());
        $this->assertEquals(new UseCaseResponseStub(), $proxy->execute(new UseCaseRequestStub()));
    }

    protected function setUp(): void
    {
        $this->builder = new UseCaseProxyBuilderImpl();
    }
}
