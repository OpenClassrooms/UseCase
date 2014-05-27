<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Transaction\Impl;

use OpenClassrooms\CleanArchitecture\Application\Services\Transaction\Transaction;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TransactionPDOAdapter implements Transaction
{
    /**
     * @var \PDO
     */
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return bool
     */
    public function beginTransaction()
    {
        return $this->isTransactionActive() ? true : $this->pdo->beginTransaction();
    }

    /**
     * @return bool
     */
    public function isTransactionActive()
    {
        return $this->pdo->inTransaction();
    }

    /**
     * @return bool
     */
    public function commit()
    {
        return $this->pdo->commit();
    }

    /**
     * @return bool
     */
    public function rollBack()
    {
        return $this->pdo->rollBack();
    }
}
