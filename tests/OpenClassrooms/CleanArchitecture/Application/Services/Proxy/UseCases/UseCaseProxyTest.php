<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Services\Proxy\UseCases;

use Doctrine\Common\Annotations\AnnotationReader;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\ProxyStrategyBagFactoryImpl;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\ProxyStrategyRequestFactoryImpl;
use OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\Impl\UseCaseProxyImpl;
use OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\UseCaseProxy;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Requestors\UseCaseRequestStub;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Responders\UseCaseResponseStub;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\UseCaseStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseProxyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UseCaseProxy
     */
    private $useCaseProxy;

    /**
     * @test
     */
    public function UseCase_Execute_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new UseCaseStub());
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());

        $this->assertEquals(new UseCaseResponseStub(), $response);
    }

    protected function setUp()
    {
        $this->useCaseProxy = new UseCaseProxyImpl();
        $this->useCaseProxy->setReader(new AnnotationReader());
        $this->useCaseProxy->setProxyStrategyBagFactory(new ProxyStrategyBagFactoryImpl());
        $this->useCaseProxy->setProxyStrategyRequestFactory(new ProxyStrategyRequestFactoryImpl());
    }
}
