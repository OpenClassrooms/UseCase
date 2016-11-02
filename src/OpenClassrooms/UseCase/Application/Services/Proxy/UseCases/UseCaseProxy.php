<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\UseCases;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Reader;
use OpenClassrooms\UseCase\Application\Annotations\Cache;
use OpenClassrooms\UseCase\Application\Annotations\Event;
use OpenClassrooms\UseCase\Application\Annotations\Log;
use OpenClassrooms\UseCase\Application\Annotations\Security;
use OpenClassrooms\UseCase\Application\Annotations\Transaction;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyBag;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyBagFactory;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequestFactory;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
abstract class UseCaseProxy implements UseCase
{

    /**
     * @var array
     */
    public static $strategyPreOrder = array(
        1 => ProxyStrategy::LOG,
        2 => ProxyStrategy::SECURITY,
        3 => ProxyStrategy::EVENT,
        4 => ProxyStrategy::CACHE,
        5 => ProxyStrategy::TRANSACTION,
    );

    /**
     * @var array
     */
    public static $strategyOnExceptionOrder = array(
        1 => ProxyStrategy::LOG,
        2 => ProxyStrategy::TRANSACTION,
        3 => ProxyStrategy::CACHE,
        4 => ProxyStrategy::EVENT,
        5 => ProxyStrategy::SECURITY,
    );

    /**
     * @var array
     */
    public static $strategyPostOrder = array(
        1 => ProxyStrategy::TRANSACTION,
        2 => ProxyStrategy::CACHE,
        3 => ProxyStrategy::EVENT,
        4 => ProxyStrategy::LOG,
        5 => ProxyStrategy::SECURITY,
    );

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var UseCase
     */
    protected $useCase;

    /**
     * @var UseCaseRequest
     */
    protected $useCaseRequest;

    /**
     * @var ProxyStrategyBagFactory
     */
    protected $proxyStrategyBagFactory;

    /**
     * @var ProxyStrategyRequestFactory
     */
    protected $proxyStrategyRequestFactory;

    /**
     * @var UseCaseResponse
     */
    private $useCaseResponse;

    /**
     * @var ProxyStrategyBag[]
     */
    private $strategies = array();

    /**
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        $this->useCaseRequest = $useCaseRequest;
        $this->buildStrategies();

        try {
            list($response, $stopExecution) = $this->preExecute();

            if ($stopExecution) {
                $this->useCaseResponse = $response;
            } else {
                $this->useCaseResponse = $this->useCase->execute($useCaseRequest);
            }

            $this->postExecute();

            return $this->useCaseResponse;
        } catch (\Exception $e) {
            $this->onException($e);
            throw $e;
        }
    }

    private function buildStrategies()
    {
        if (empty($this->strategies)) {
            $annotations = $this->getAnnotations();
            foreach ($annotations as $annotation) {
                if ($annotation instanceof Security
                    || $annotation instanceof Cache
                    || $annotation instanceof Transaction
                    || $annotation instanceof Event
                    || $annotation instanceof Log
                ) {
                    $this->strategies[] = $this->proxyStrategyBagFactory->make($annotation);
                }
            }
        }
    }

    /**
     * @return Annotation[]
     */
    private function getAnnotations()
    {
        return $this->reader->getMethodAnnotations(new \ReflectionMethod($this->useCase, 'execute'));
    }

    /**
     * @return array
     */
    private function preExecute()
    {
        $stopExecution = false;
        $data = null;

        $this->sortPreStrategies();

        foreach ($this->strategies as $strategy) {
            if ($strategy->isPreExecute()) {
                $request = $this->proxyStrategyRequestFactory->createPreExecuteRequest(
                    $strategy->getAnnotation(),
                    $this->useCase,
                    $this->useCaseRequest
                );

                $strategyResponse = $strategy->preExecute($request);

                if ($strategyResponse->stopExecution()) {
                    $stopExecution = true;
                    $this->removeTransactionStrategy();
                    $data = $strategyResponse->getData();
                    break;
                }
            }
        }

        return array($data, $stopExecution);
    }

    private function sortPreStrategies()
    {
        usort(
            $this->strategies,
            function (ProxyStrategyBag $s1, ProxyStrategyBag $s2) {
                return array_search($s1->getType(), UseCaseProxy::$strategyPreOrder) >
                array_search($s2->getType(), UseCaseProxy::$strategyPreOrder);
            }
        );
    }

    private function removeTransactionStrategy()
    {
        foreach ($this->strategies as $key => $strategy) {
            if (ProxyStrategy::TRANSACTION === $strategy->getType()) {
                unset($this->strategies[$key]);
            }
        }
    }

    private function postExecute()
    {
        $this->sortPostStrategies();
        foreach ($this->strategies as $strategy) {
            if ($strategy->isPostExecute()) {
                $request = $this->proxyStrategyRequestFactory->createPostExecuteRequest(
                    $strategy->getAnnotation(),
                    $this->useCase,
                    $this->useCaseRequest,
                    $this->useCaseResponse
                );
                $strategy->postExecute($request);
            }
        }
    }

    private function sortPostStrategies()
    {
        usort(
            $this->strategies,
            function (ProxyStrategyBag $s1, ProxyStrategyBag $s2) {
                return array_search($s1->getType(), UseCaseProxy::$strategyPostOrder) >
                array_search($s2->getType(), UseCaseProxy::$strategyPostOrder);
            }
        );
    }

    private function onException(\Exception $exception)
    {
        $this->sortOnExceptionStrategies();
        foreach ($this->strategies as $strategy) {
            if ($strategy->isOnException()) {
                $request = $this->proxyStrategyRequestFactory->createOnExceptionRequest(
                    $strategy->getAnnotation(),
                    $this->useCase,
                    $this->useCaseRequest,
                    $exception
                );
                $strategy->onException($request);
            }
        }
    }

    private function sortOnExceptionStrategies()
    {
        usort(
            $this->strategies,
            function (ProxyStrategyBag $s1, ProxyStrategyBag $s2) {
                return array_search($s1->getType(), UseCaseProxy::$strategyOnExceptionOrder) >
                array_search($s2->getType(), UseCaseProxy::$strategyOnExceptionOrder);
            }
        );
    }

    /**
     * @return UseCase
     */
    public function getUseCase()
    {
        return $this->useCase;
    }

    public function setUseCase(UseCase $useCase)
    {
        $this->useCase = $useCase;
    }
}
