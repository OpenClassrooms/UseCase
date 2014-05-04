<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Services\Proxy\UseCases;

use Doctrine\Common\Annotations\AnnotationReader;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\ProxyStrategyBagFactoryImpl;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\ProxyStrategyRequestFactoryImpl;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Transaction\TransactionProxyStrategy;
use OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\Impl\UseCaseProxyImpl;
use OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\UseCaseProxy;
use OpenClassrooms\Tests\CleanArchitecture\Application\Services\Transaction\TransactionSpy;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Exceptions\UseCaseException;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Requestors\UseCaseRequestStub;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\ExceptionUseCaseStub;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\Transaction\OnlyTransactionUseCaseStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TransactionUseCaseProxyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UseCaseProxy
     */
    private $useCaseProxy;

    /**
     * @var TransactionSpy
     */
    private $transaction;

    /**
     * @test
     */
    public function Transaction_Commit()
    {
        $this->useCaseProxy->setUseCase(new \OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\Transaction\OnlyTransactionUseCaseStub());
        $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertTrue($this->transaction->committed);
        $this->assertFalse($this->transaction->rollBacked);
    }

    /**
     * @test
     */
    public function Exception_Transaction_RollBack()
    {
        try {
            $this->useCaseProxy->setUseCase(new ExceptionUseCaseStub());
            $this->useCaseProxy->execute(new UseCaseRequestStub());
            $this->fail();
        } catch (UseCaseException $e) {
            $this->assertFalse($this->transaction->committed);
            $this->assertTrue($this->transaction->rollBacked);
        }
    }

    protected function setUp()
    {
        $proxyStrategyBagFactory = new ProxyStrategyBagFactoryImpl();
        $proxyStrategyBagFactory->setTransactionStrategy($this->buildTransactionStrategy());

        $proxyStrategyRequestFactory = new ProxyStrategyRequestFactoryImpl();

        $this->useCaseProxy = new UseCaseProxyImpl();
        $this->useCaseProxy->setReader(new AnnotationReader());
        $this->useCaseProxy->setProxyStrategyBagFactory($proxyStrategyBagFactory);
        $this->useCaseProxy->setProxyStrategyRequestFactory($proxyStrategyRequestFactory);
    }

    /**
     * @return TransactionProxyStrategy
     */
    protected function buildTransactionStrategy()
    {
        $this->transaction = new TransactionSpy();

        $transactionStrategy = new TransactionProxyStrategy();
        $transactionStrategy->setTransaction($this->transaction);

        return $transactionStrategy;
    }
}
