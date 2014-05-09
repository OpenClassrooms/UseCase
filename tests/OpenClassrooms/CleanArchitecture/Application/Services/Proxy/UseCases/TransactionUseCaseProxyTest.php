<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Services\Proxy\UseCases;

use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Exceptions\UseCaseException;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Requestors\UseCaseRequestStub;
use
    OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\Transaction\ExceptionTransactionUseCaseStub;
use
    OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\Transaction\OnlyTransactionUseCaseStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TransactionUseCaseProxyTest extends UseCaseProxyTest
{
    /**
     * @test
     */
    public function Transaction_Commit()
    {
        $this->useCaseProxy->setUseCase(new OnlyTransactionUseCaseStub());
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
            $this->useCaseProxy->setUseCase(new ExceptionTransactionUseCaseStub());
            $this->useCaseProxy->execute(new UseCaseRequestStub());
            $this->fail();
        } catch (UseCaseException $e) {
            $this->assertFalse($this->transaction->committed);
            $this->assertTrue($this->transaction->rollBacked);
        }
    }
}
