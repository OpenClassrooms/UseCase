<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Proxy\UseCases;

use OpenClassrooms\Tests\UseCase\BusinessRules\Exceptions\UseCaseException;
use OpenClassrooms\Tests\UseCase\BusinessRules\Requestors\UseCaseRequestStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\Responders\Doubles\UseCaseResponseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Cache\ExceptionCacheUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Cache\LifeTimeCacheUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Cache\NamespaceCacheUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Cache\OnlyCacheUseCaseStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class CacheUseCaseProxyTest extends AbstractUseCaseProxyTest
{
    /**
     * @test
     */
    public function OnlyCache_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new OnlyCacheUseCaseStub());
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(new UseCaseResponseStub(), $response);
        $this->assertTrue($this->cache->saved);
    }

    /**
     * @test
     */
    public function Cached_OnlyCache_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new OnlyCacheUseCaseStub());
        $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertTrue($this->cache->saved);
        $this->cache->saved = false;
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(new UseCaseResponseStub(), $response);
        $this->assertTrue($this->cache->fetched);
        $this->assertFalse($this->cache->saved);
    }

    /**
     * @test
     */
    public function WithNamespace_Cache_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new NamespaceCacheUseCaseStub());
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(new UseCaseResponseStub(), $response);
        $this->assertTrue($this->cache->savedWithNamespace);
        $this->assertEquals(
            NamespaceCacheUseCaseStub::NAMESPACE_PREFIX.UseCaseRequestStub::FIELD_VALUE,
            $this->cache->namespaceId
        );
    }

    /**
     * @test
     */
    public function CachedWithNamespace_Cache_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new NamespaceCacheUseCaseStub());
        $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertTrue($this->cache->savedWithNamespace);
        $this->cache->savedWithNamespace = false;
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(new UseCaseResponseStub(), $response);
        $this->assertTrue($this->cache->fetched);
        $this->assertFalse($this->cache->savedWithNamespace);
    }

    /**
     * @test
     */
    public function WithLifeTime_Cache_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new LifeTimeCacheUseCaseStub());
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(new UseCaseResponseStub(), $response);
        $this->assertTrue($this->cache->saved);
        $this->assertEquals(LifeTimeCacheUseCaseStub::LIFETIME, $this->cache->lifeTime);
    }

    /**
     * @test
     */
    public function CacheOnException_DonTSave()
    {
        try {
            $this->useCaseProxy->setUseCase(new ExceptionCacheUseCaseStub());
            $this->useCaseProxy->execute(new UseCaseRequestStub());
            $this->fail('Exception should be thrown');
        } catch (UseCaseException $e) {
            $this->assertFalse($this->cache->saved);
        }
    }
}
