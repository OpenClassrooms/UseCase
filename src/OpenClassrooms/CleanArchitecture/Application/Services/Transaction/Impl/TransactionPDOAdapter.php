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
    private $pdo;

    /**
     * @return bool
     */
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
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

    public function setPdo(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}
