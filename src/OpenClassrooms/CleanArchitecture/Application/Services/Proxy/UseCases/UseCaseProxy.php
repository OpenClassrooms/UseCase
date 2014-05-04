<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Reader;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\ProxyStrategyBagImpl;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyBagFactory;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequestFactory;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCase;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class UseCaseProxy implements UseCase
{
    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var ProxyStrategyBagFactory
     */
    protected $proxyStrategyBagFactory;

    /**
     * @var ProxyStrategyRequestFactory
     */
    protected $proxyStrategyRequestFactory;

    /**
     * @var UseCase
     */
    protected $useCase;

    /**
     * @var UseCaseRequest
     */
    protected $request;

    /**
     * @var ProxyStrategyBagImpl[]
     */
    private $strategies = array();

    /**
     * @var UseCaseResponse
     */
    private $response;

    /**
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        $this->request = $useCaseRequest;
        $this->buildStrategies();

        try {
            list($stopExecution, $response) = $this->preExecute();
            if ($stopExecution) {
                return $response;
            }
            $this->response = $this->useCase->execute($useCaseRequest);

            $this->postExecute();

            return $this->response;
        } catch (\Exception $e) {
            $this->onException();
            throw $e;
        }
    }

    private function buildStrategies()
    {
        $annotations = $this->getAnnotations();
        foreach ($annotations as $annotation) {
            try {
                $this->strategies[] = $this->proxyStrategyBagFactory->make($annotation);
            } catch (\Exception $e) {

            }
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
     * @return array
     */
    private function preExecute()
    {
        $stopExecution = false;
        $data = null;

        foreach ($this->strategies as $strategy) {

            $request = $this->proxyStrategyRequestFactory->createPreExecuteRequest(
                $strategy->getAnnotation(),
                $this->request
            );
            $strategyResponse = $strategy->preExecute($request);

            if ($strategyResponse->stopExecution()) {
                $stopExecution = true;
                $data = $strategyResponse->getData();
                break;
            }
        }

        return array($stopExecution, $data);
    }

    private function postExecute()
    {
        foreach ($this->strategies as $strategy) {
            $request = $this->proxyStrategyRequestFactory->createPostExecuteRequest(
                $strategy->getAnnotation(),
                $this->request,
                $this->response
            );
            $strategy->postExecute($request);
        }
    }

    private function onException()
    {
        foreach ($this->strategies as $strategy) {

            $request = $this->proxyStrategyRequestFactory->createOnExceptionRequest(
                $strategy->getAnnotation(),
                $this->request
            );
            $strategy->onException($request);
        }
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
