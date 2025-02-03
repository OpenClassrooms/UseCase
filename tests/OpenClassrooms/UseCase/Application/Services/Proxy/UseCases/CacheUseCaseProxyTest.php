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
class CacheUseCaseProxyTest extends AbstractUseCaseProxyTestCase
{
    /**
     * @test
     */
    public function OnlyCache_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new OnlyCacheUseCaseStub());
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(new UseCaseResponseStub(), $response);
        $this->assertNotEmpty($this->cache->saved);
    }

    /**
     * @test
     */
    public function Cached_OnlyCache_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new OnlyCacheUseCaseStub());
        $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertCount(1, $this->cache->saved);

        $this->cache->saved = [];

        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(new UseCaseResponseStub(), $response);
        $this->assertCount(1, $this->cache->getted);
        $this->assertContains(true, $this->cache->getted);
        $this->assertEmpty($this->cache->saved);
    }

    /**
     * @test
     */
    public function WithNamespace_Cache_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new NamespaceCacheUseCaseStub());
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(new UseCaseResponseStub(), $response);
        $this->assertCount(2, $this->cache->saved);
        $this->assertContains(
            NamespaceCacheUseCaseStub::NAMESPACE_PREFIX.UseCaseRequestStub::FIELD_VALUE,
            array_keys($this->cache->saved)
        );
    }

    /**
     * @test
     */
    public function CachedWithNamespace_Cache_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new NamespaceCacheUseCaseStub());
        $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertCount(2, $this->cache->saved);

        $this->cache->saved = [];
        $this->cache->getted = [];

        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(new UseCaseResponseStub(), $response);
        $this->assertCount(2, $this->cache->getted);
        $this->assertEmpty($this->cache->saved);
    }

    /**
     * @test
     */
    public function WithLifeTime_Cache_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new LifeTimeCacheUseCaseStub());
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(new UseCaseResponseStub(), $response);
        $this->assertCount(1, $this->cache->saved);

        $this->assertNotContains(null, $this->cache->saved);
        $this->assertEqualsWithDelta(time() + LifeTimeCacheUseCaseStub::LIFETIME, array_pop($this->cache->saved), 2.0);
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
            $this->assertEmpty($this->cache->saved);
        }
    }
}
