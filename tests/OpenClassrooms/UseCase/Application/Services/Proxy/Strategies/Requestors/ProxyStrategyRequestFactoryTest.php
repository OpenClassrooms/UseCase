<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Proxy\Strategies\Requestors;

use OpenClassrooms\Tests\UseCase\BusinessRules\Exceptions\UseCaseException;
use OpenClassrooms\Tests\UseCase\BusinessRules\Requestors\UseCaseRequestStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\Responders\Doubles\UseCaseResponseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Exceptions\UnSupportedAnnotationException;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\ProxyStrategyRequestFactoryImpl;
use PHPUnit\Framework\TestCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class ProxyStrategyRequestFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function UnsupportedAnnotation_CreatePreExecuteRequest_ThrowException()
    {
        $factory = new ProxyStrategyRequestFactoryImpl();

        $this->expectException(UnSupportedAnnotationException::class);

        $factory->createPreExecuteRequest('unsupported annotation', new UseCaseStub(), new UseCaseRequestStub());
    }

    /**
     * @test
     */
    public function UnsupportedAnnotation_CreatePostExecuteRequest_ThrowException()
    {
        $factory = new ProxyStrategyRequestFactoryImpl();

        $this->expectException(UnSupportedAnnotationException::class);

        $factory->createPostExecuteRequest(
            'unsupported annotation',
            new UseCaseStub(),
            new UseCaseRequestStub(),
            new UseCaseResponseStub()
        );
    }

    /**
     * @test
     */
    public function UnsupportedAnnotation_CreateOnExceptionRequest_ThrowException()
    {
        $factory = new ProxyStrategyRequestFactoryImpl();

        $this->expectException(UnSupportedAnnotationException::class);

        $factory->createOnExceptionRequest(
            'unsupported annotation',
            new UseCaseStub(),
            new UseCaseRequestStub(),
            new UseCaseException()
        );
    }
}
