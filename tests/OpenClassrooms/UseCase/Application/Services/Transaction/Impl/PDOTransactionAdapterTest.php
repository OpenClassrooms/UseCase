<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Transaction\Impl;

use OpenClassrooms\UseCase\Application\Services\Transaction\Impl\PDOTransactionAdapter;
use OpenClassrooms\UseCase\Application\Services\Transaction\Transaction;
use PHPUnit\Framework\TestCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class PDOTransactionAdapterTest extends TestCase
{

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * @test
     */
    public function BeginTransaction_ReturnTransaction()
    {
        $transactionBegin = $this->transaction->beginTransaction();
        $this->assertTrue($transactionBegin);
        $this->assertTrue($this->pdo->inTransaction());
        $this->assertTrue($this->transaction->isTransactionActive());
    }

    /**
     * @test
     */
    public function WithoutTransaction_Commit_ThrowException()
    {
        $this->expectException(\PDOException::class);
        $this->expectExceptionMessage('There is no active transaction');
        $this->transaction->commit();
    }

    /**
     * @test
     */
    public function Commit()
    {
        $this->transaction->beginTransaction();
        $committed = $this->transaction->commit();
        $this->assertTrue($committed);
        $this->assertFalse($this->pdo->inTransaction());
        $this->assertFalse($this->transaction->isTransactionActive());
    }

    /**
     * @test
     */
    public function WithoutTransaction_RollBack_ThrowException()
    {
        $this->expectException(\PDOException::class);
        $this->expectExceptionMessage('There is no active transaction');

        $this->transaction->rollBack();
    }

    /**
     * @test
     */
    public function RollBack()
    {
        $this->transaction->beginTransaction();
        $rollBacked = $this->transaction->rollBack();
        $this->assertTrue($rollBacked);
        $this->assertFalse($this->pdo->inTransaction());
        $this->assertFalse($this->transaction->isTransactionActive());
    }

    protected function setUp(): void
    {
        $this->pdo = new \PDO('sqlite::memory:');
        $this->transaction = new PDOTransactionAdapter($this->pdo);
    }
}
