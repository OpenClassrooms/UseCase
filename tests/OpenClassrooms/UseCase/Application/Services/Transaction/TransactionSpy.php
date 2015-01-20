<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Transaction;

use OpenClassrooms\UseCase\Application\Services\Transaction\Transaction;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class TransactionSpy implements Transaction
{
    /**
     * @var int
     */
    private static $transactionNumber = 0;

    /**
     * @var bool
     */
    public $transactionBegin = false;

    /**
     * @var bool
     */
    public $committed = false;

    /**
     * @var bool
     */
    public $rollBacked = false;

    /**
     * @return bool
     */
    public function beginTransaction()
    {
        $this->transactionBegin = true;
        self::$transactionNumber++;

        return true;
    }

    /**
     * @return bool
     */
    public function commit()
    {
        if (!$this->isTransactionActive()) {
            throw new \Exception('transaction is not active');
        }
        self::$transactionNumber--;
        $this->committed = true;

        return true;
    }

    /**
     * @return bool
     */
    public function isTransactionActive()
    {
        return self::$transactionNumber > 0;
    }

    /**
     * @return bool
     */
    public function rollBack()
    {
        if (!$this->isTransactionActive()) {
            throw new \Exception('transaction is not active');
        }
        self::$transactionNumber--;
        $this->rollBacked = true;

        return true;
    }
}
