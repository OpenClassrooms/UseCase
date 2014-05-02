<?php

namespace OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Requestors;

use Doctrine\Common\Annotations\AnnotationReader;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Strategies\Cache\CacheProxyStrategy;
use
    OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Strategies\Cache\DTO\CacheProxyStrategyRequestBuilderImpl;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Strategies\ProxyStrategyBagFactoryImpl;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseProxy;
use OpenClassrooms\CleanArchitecture\BusinessRules\UseCases\UseCaseProxyImpl;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Responders\UseCaseResponseStub;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\OnlyCacheUseCaseStub;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\Tests\CleanArchitecture\Cache\CacheSpy;

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
     * @var CacheSpy
     */
    private $cache;

    /**
     * @test
     */
    public function UseCase_Execute_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new UseCaseStub());
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());

        $this->assertEquals(new UseCaseResponseStub(), $response);
        $this->assertFalse($this->cache->saved);
    }

    /**
     * @test
     */
    public function Cache_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new OnlyCacheUseCaseStub());
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(new UseCaseResponseStub(), $response);
        $this->assertTrue($this->cache->saved);
    }

    protected function setUp()
    {
        $this->cache = new CacheSpy();
        $this->useCaseProxy = new UseCaseProxyImpl();
        $this->useCaseProxy->setReader(new AnnotationReader());
        $cacheStrategy = new CacheProxyStrategy();
        $cacheStrategy->setCache($this->cache);
        $proxyStrategyBagFactory = new ProxyStrategyBagFactoryImpl();
        $proxyStrategyBagFactory->setCacheStrategy($cacheStrategy);
        $proxyStrategyBagFactory->setCacheProxyStrategyRequestBuilder(new CacheProxyStrategyRequestBuilderImpl());
        $this->useCaseProxy->setProxyStrategyBagFactory($proxyStrategyBagFactory);
    }

}
