<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\Requestors;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Reader;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\ProxyStrategyBagFactory;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Strategies\ProxyStrategyBagImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class UseCaseProxy implements UseCase
{
    /**
     * @var UseCase
     */
    protected $useCase;

    /**
     * @var UseCaseRequest
     */
    protected $request;

    /**
     * @var Annotation[]
     */
    protected $annotations;

    /**
     * @var ProxyStrategyBagFactory
     */
    protected $proxyStrategyBagFactory;

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var ProxyStrategyBagImpl[]
     */
    private $strategies = array();

    /**
     * @return \OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        $this->request = $useCaseRequest;
        $this->buildStrategies();

        try {
            foreach ($this->strategies as $strategy) {
                $strategyResponse = $strategy->preExecute();
                if ($strategyResponse->stopExecution()) {
                    return $strategyResponse->getData();
                }
            }
            $response = $this->useCase->execute($useCaseRequest);

            foreach ($this->strategies as $strategy) {
                $strategyResponse = $strategy->postExecute();
                if ($strategyResponse->stopExecution()) {
                    return $strategyResponse->getData();
                }
            }

            return $response;
        } catch (\Exception $e) {
            foreach ($this->strategies as $strategy) {
                $strategyResponse = $strategy->onException();
                if ($strategyResponse->stopExecution()) {
                    return $strategyResponse->getData();
                }
            }
            throw $e;
        }
    }

    private function buildStrategies()
    {
        $annotations = $this->getAnnotations();
        foreach ($annotations as $annotation) {
            $this->strategies[] = $this->proxyStrategyBagFactory->make($annotation, $this->request);
        }
    }

    /**
     * @return Annotation[]
     */
    private function getAnnotations()
    {
        $reflectionMethod = new \ReflectionMethod($this->useCase, 'execute');

        return $this->reader->getMethodAnnotations($reflectionMethod);
    }

    /**
     * @return \OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCase
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
