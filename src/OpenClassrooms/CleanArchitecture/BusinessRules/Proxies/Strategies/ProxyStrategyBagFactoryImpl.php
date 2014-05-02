<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Strategies;

use Doctrine\Common\Annotations\Annotation;
use OpenClassrooms\CleanArchitecture\Annotations\Cache;
use OpenClassrooms\CleanArchitecture\Annotations\Event;
use OpenClassrooms\CleanArchitecture\Annotations\Security;
use OpenClassrooms\CleanArchitecture\Annotations\Transaction;
use
    OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Exceptions\UnSupportedAnnotationException;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\ProxyStrategyBagFactory;
use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Strategies\Cache\CacheProxyStrategy;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ProxyStrategyBagFactoryImpl implements ProxyStrategyBagFactory
{
    /**
     * @var CacheProxyStrategy
     */
    private $cacheStrategy;

    /**
     * @return ProxyStrategyBagImpl
     */
    public function make($annotation)
    {
                $strategyBag = new ProxyStrategyBagImpl();
        switch ($annotation) {
            case $annotation instanceof Security:
                break;
            case $annotation instanceof Cache:
                $strategyBag->setProxyStrategy($this->cacheStrategy);
                $strategyBag->setAnnotation($annotation);
                break;
            case $annotation instanceof Transaction:
                break;
            case $annotation instanceof Event:
                break;
            default:
                throw new UnSupportedAnnotationException();
        }

        return $strategyBag;
    }

    public function setCacheStrategy(CacheProxyStrategy $cacheStrategy)
    {
        $this->cacheStrategy = $cacheStrategy;
    }
}
