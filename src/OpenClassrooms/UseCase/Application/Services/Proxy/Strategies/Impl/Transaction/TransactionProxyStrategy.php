<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Transaction;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\DTO\ProxyStrategyResponseDTO;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\OnExceptionProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\PostExecuteProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\PreExecuteProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequest;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Responders\ProxyStrategyResponse;
use OpenClassrooms\UseCase\Application\Services\Transaction\Transaction;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class TransactionProxyStrategy implements PreExecuteProxyStrategy, PostExecuteProxyStrategy, OnExceptionProxyStrategy
{

    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * @return string
     */
    public function getType()
    {
        return ProxyStrategy::TRANSACTION;
    }

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
