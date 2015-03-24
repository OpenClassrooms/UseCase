<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Log\DTO;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Log\LogProxyStrategyRequest;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class LogProxyStrategyRequestDTO implements LogProxyStrategyRequest
{

    /**
     * @var array
     */
    public $context = array();

    /**
     * @var \Exception
     */
    public $exception;

    /**
     * @var string
     */
    public $level;

    /**
     * @var string
     */
    public $message;

    /**
     * @var UseCaseRequest
     */
    public $useCaseRequest;

    /**
     * @var UseCaseResponse
     */
    public $useCaseResponse;

    /**
     * @return array
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return UseCaseRequest
     */
    public function getUseCaseRequest()
    {
        return $this->useCaseRequest;
    }

    /**
     * @return UseCaseResponse
     */
    public function getUseCaseResponse()
    {
        return $this->useCaseResponse;
    }
}
