<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Proxy\UseCases;

use OpenClassrooms\Tests\UseCase\Application\Services\Log\LoggerSpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Security\Exceptions\AccessDeniedException;
use OpenClassrooms\Tests\UseCase\BusinessRules\Exceptions\UseCaseException;
use OpenClassrooms\Tests\UseCase\BusinessRules\Requestors\UseCaseRequestStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\Responders\Doubles\UseCaseResponseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\WithoutResponseUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Workflow\AllAnnotationsNotAuthorizedUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Workflow\AllAnnotationsUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Workflow\ExceptionAllAnnotationsUseCaseStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class WorkflowUseCaseProxyTest extends AbstractUseCaseProxyTestCase
{
    /**
     * @test
     */
    public function UseCase_Execute_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new UseCaseStub());
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());

        $this->assertEquals(new UseCaseResponseStub(), $response);
    }

    /**
     * @test
     */
    public function UseCaseWithoutResponse_Execute_DonTThrowException()
    {
        $this->useCaseProxy->setUseCase(new WithoutResponseUseCaseStub());
        $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function SecurityException_ThrowException()
    {
        try {
            $this->useCaseProxy->setUseCase(new AllAnnotationsNotAuthorizedUseCaseStub());
            $this->useCaseProxy->execute(new UseCaseRequestStub());
            $this->fail();
        } catch (AccessDeniedException $ade) {
            $this->assertCacheWasNotCalled();
            $this->assertTransactionWasCalledOnUnAuthorizedException();
            $this->assertEventWasNotCalled();
            $this->assertLogOnException();
        }
    }

    private function assertCacheWasNotCalled()
    {
        $this->assertEmpty($this->cache->getted);
        $this->assertEmpty($this->cache->saved);
    }

    private function assertTransactionWasCalledOnUnAuthorizedException()
    {
        $this->assertFalse($this->transaction->transactionBegin);
        $this->assertFalse($this->transaction->committed);
        $this->assertFalse($this->transaction->rollBacked);
    }

    private function assertEventWasNotCalled()
    {
        $this->assertEmpty($this->event->events);
    }

    private function assertLogOnException()
    {
        $this->assertEquals(AllAnnotationsNotAuthorizedUseCaseStub::PRE_LEVEL, LoggerSpy::$level[0]);
        $this->assertEquals(AllAnnotationsNotAuthorizedUseCaseStub::ON_EXCEPTION_LEVEL, LoggerSpy::$level[1]);
        $this->assertCount(2, LoggerSpy::$level);
    }

    /**
     * @test
     */
    public function AllAnnotation_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new AllAnnotationsUseCaseStub());
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(new UseCaseResponseStub(), $response);
        $this->assertCacheSaveWasCalled();
        $this->assertTransactionWasCalled();
        $this->assertEventWasCalled();
        $this->assertPrePostLog();
    }

    private function assertCacheSaveWasCalled()
    {
        $this->assertNotEmpty($this->cache->getted);
        $this->assertNotEmpty($this->cache->saved);
    }

    private function assertTransactionWasCalled()
    {
        $this->assertTrue($this->transaction->transactionBegin);
        $this->assertTrue($this->transaction->committed);
        $this->assertFalse($this->transaction->rollBacked);
    }

    private function assertEventWasCalled()
    {
        $this->assertCount(2, $this->event->events);
    }

    private function assertPrePostLog()
    {
        $this->assertEquals(AllAnnotationsUseCaseStub::PRE_LEVEL, LoggerSpy::$level[0]);
        $this->assertEquals(AllAnnotationsUseCaseStub::POST_LEVEL, LoggerSpy::$level[1]);
        $this->assertCount(2, LoggerSpy::$level);
    }

    /**
     * @test
     */
    public function Cached_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new AllAnnotationsUseCaseStub());
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->resetCache();
        $this->resetEvent();
        $this->resetLog();
        $this->resetTransaction();
        $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(new UseCaseResponseStub(), $response);
        $this->assertCacheWasCalled();
        $this->assertTransactionWasNotCalled();
        $this->assertEventWasCalled();
        $this->assertPrePostLog();
    }

    private function resetCache()
    {
        $this->cache->getted = [];
        $this->cache->saved = [];
    }

    private function resetEvent()
    {
        $this->event->events = array();
    }

    private function resetLog()
    {
        LoggerSpy::$level = array();
        LoggerSpy::$message = array();
        LoggerSpy::$context = array();
    }

    private function resetTransaction()
    {
        $this->transaction->transactionBegin = false;
        $this->transaction->committed = false;
        $this->transaction->rollBacked = false;
    }

    private function assertCacheWasCalled()
    {
        $this->assertContains(true, $this->cache->getted);
        $this->assertEmpty($this->cache->saved);
    }

    private function assertTransactionWasNotCalled()
    {
        $this->assertFalse($this->transaction->transactionBegin);
        $this->assertFalse($this->transaction->committed);
        $this->assertFalse($this->transaction->rollBacked);
    }

    /**
     * @test
     */
    public function AllAnnotationException_ThrowException()
    {
        try {
            $this->useCaseProxy->setUseCase(new ExceptionAllAnnotationsUseCaseStub());
            $this->useCaseProxy->execute(new UseCaseRequestStub());
            $this->fail();
        } catch (UseCaseException $e) {
            $this->assertCacheSaveWasNotCalled();
            $this->assertTransactionWasCalledOnException();
            $this->assertEventWasCalledOnException();
            $this->assertLogOnException();
        }
    }

    private function assertCacheSaveWasNotCalled()
    {
        $this->assertNotEmpty($this->cache->getted);
        $this->assertContains(false, $this->cache->getted);
        $this->assertEmpty($this->cache->saved);
    }

    private function assertTransactionWasCalledOnException()
    {
        $this->assertTrue($this->transaction->transactionBegin);
        $this->assertFalse($this->transaction->committed);
        $this->assertTrue($this->transaction->rollBacked);
    }

    private function assertEventWasCalledOnException()
    {
        $this->assertCount(2, $this->event->events);
    }
}
