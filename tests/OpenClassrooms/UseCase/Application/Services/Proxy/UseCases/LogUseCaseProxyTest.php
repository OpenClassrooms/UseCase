<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Proxy\UseCases;

use OpenClassrooms\Tests\UseCase\Application\Services\Log\LoggerSpy;
use OpenClassrooms\Tests\UseCase\BusinessRules\Exceptions\UseCaseException;
use OpenClassrooms\Tests\UseCase\BusinessRules\Requestors\UseCaseRequestStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\Responders\Doubles\UseCaseResponseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Log\ExceptionLogUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Log\LogUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Log\MultiLogUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Log\OnlyLogUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Log\PostLogUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Log\PreLogUseCaseStub;
use Psr\Log\LogLevel;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class LogUseCaseProxyTest extends AbstractUseCaseProxyTest
{
    /**
     * @test
     */
    public function OnlyLog_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new OnlyLogUseCaseStub());
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(new UseCaseResponseStub(), $response);
    }

    /**
     * @test
     */
    public function Log_ReturnResponse()
    {
        try {
            $this->useCaseProxy->setUseCase(new LogUseCaseStub());
            $this->useCaseProxy->execute(new UseCaseRequestStub());
        } catch (UseCaseException $uce) {
            $this->assertEquals('message with context {foo}', LoggerSpy::$message[0]);
            $this->assertEquals(array('foo' => 'bar'), LoggerSpy::$context[0]);
        }
    }

    /**
     * @test
     */
    public function OnException_LogException()
    {
        try {
            $this->useCaseProxy->setUseCase(new ExceptionLogUseCaseStub());
            $this->useCaseProxy->execute(new UseCaseRequestStub());
            $this->fail('Exception should be thrown');
        } catch (UseCaseException $e) {
            $this->assertEquals(LogLevel::WARNING, LoggerSpy::$level[0]);
        }
    }

    /**
     * @test
     */
    public function Pre_Log()
    {
        $this->useCaseProxy->setUseCase(new PreLogUseCaseStub());
        $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(LogLevel::WARNING, LoggerSpy::$level[0]);
        $this->assertEquals(PreLogUseCaseStub::MESSAGE, LoggerSpy::$message[0]);
    }

    /**
     * @test
     */
    public function Post_Log()
    {
        $this->useCaseProxy->setUseCase(new PostLogUseCaseStub());
        $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(LogLevel::WARNING, LoggerSpy::$level[0]);
        $this->assertEquals(PostLogUseCaseStub::MESSAGE, LoggerSpy::$message[0]);
    }

    /**
     * @test
     */
    public function Multi_Log()
    {
        $this->useCaseProxy->setUseCase(new MultiLogUseCaseStub());
        $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(MultiLogUseCaseStub::PRE_LEVEL, LoggerSpy::$level[0]);
        $this->assertEquals(MultiLogUseCaseStub::PRE_MESSAGE, LoggerSpy::$message[0]);
        $this->assertEquals(MultiLogUseCaseStub::$preContext, LoggerSpy::$context[0]);
        $this->assertEquals(MultiLogUseCaseStub::POST_LEVEL, LoggerSpy::$level[1]);
        $this->assertEquals(MultiLogUseCaseStub::POST_MESSAGE, LoggerSpy::$message[1]);
        $this->assertEquals(MultiLogUseCaseStub::$postContext, LoggerSpy::$context[1]);
    }
}
