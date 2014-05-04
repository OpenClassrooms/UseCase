<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\ProxyStrategyRequestFactoryImpl;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Requestors\UseCaseRequestStub;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Responders\UseCaseResponseStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ProxyStrategyRequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Exceptions\UnSupportedAnnotationException
     */
    public function UnsupportedAnnotation_CreatePreExecuteRequest_ThrowException()
    {
        $factory = new ProxyStrategyRequestFactoryImpl();
        $factory->createPreExecuteRequest('unsupported annotation', new UseCaseRequestStub());
    }

    /**
     * @test
     * @expectedException \OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Exceptions\UnSupportedAnnotationException
     */
    public function UnsupportedAnnotation_CreatePostExecuteRequest_ThrowException()
    {
        $factory = new ProxyStrategyRequestFactoryImpl();
        $factory->createPostExecuteRequest('unsupported annotation', new UseCaseRequestStub(), new UseCaseResponseStub());
    }
}
