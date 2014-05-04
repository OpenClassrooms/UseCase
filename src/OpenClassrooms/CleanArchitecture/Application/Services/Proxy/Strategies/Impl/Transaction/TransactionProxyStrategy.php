<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Transaction;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\DTO\ProxyStrategyResponseDTO;
use OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\ProxyStrategy;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequest;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Responders\ProxyStrategyResponse;
use OpenClassrooms\CleanArchitecture\Application\Services\Transaction\Transaction;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TransactionProxyStrategy implements ProxyStrategy
{
    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * @return ProxyStrategyResponse
     */
    public function preExecute(ProxyStrategyRequest $proxyStrategyRequest)
    {
        $this->transaction->beginTransaction();

        return new ProxyStrategyResponseDTO();
    }

    /**
     * @return ProxyStrategyResponse
     */
    public function postExecute(ProxyStrategyRequest $proxyStrategyRequest)
    {
        return $this->transaction->commit();
    }

    /**
     * @return ProxyStrategyResponse
     */
    public function onException(ProxyStrategyRequest $proxyStrategyRequest)
    {
        return $this->transaction->rollBack();
    }

    public function setTransaction(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }
}
