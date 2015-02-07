UseCase
=======
[![Build Status](https://travis-ci.org/OpenClassrooms/UseCase.svg?branch=master)](https://travis-ci.org/OpenClassrooms/UseCase)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/5b05eef1-7457-434e-8a8c-44013a6675a1/mini.png)](https://insight.sensiolabs.com/projects/5b05eef1-7457-434e-8a8c-44013a6675a1)
[![Coverage Status](https://coveralls.io/repos/OpenClassrooms/UseCase/badge.png?branch=master)](https://coveralls.io/r/OpenClassrooms/UseCase?branch=master)

UseCase is a library that provides facilities to manage technical code over a Use Case in a Clean / Hexagonal / Use Case Architecture.
- Security access
- Cache management
- Transactional context
- Events
- Logs

The goal is to have only functional code on the Use Case and manage technical code in an elegant way using annotations.

More details on :
- [Clean Architecture](http://blog.8thlight.com/uncle-bob/2012/08/13/the-clean-architecture.html).
- [Hexagonal Architecture](http://alistair.cockburn.us/Hexagonal+architecture).
- [Use Case Driven Development](http://www.ivarjacobson.com/Use_Case_Driven_Development/).

## Installation
```composer require openclassrooms/use-case```
or by adding the package to the composer.json file directly.

```json
{
    "require": {
        "openclassrooms/use-case": "*"
    }
}
```
```php

<?php
require 'vendor/autoload.php';

use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxy;

//do things
```
<a name="install-nocomposer"/>

### Instantiation
The UseCaseProxy needs a lot of dependencies. 

The Dependency Injection Pattern is clearly helpful.

For an implementation with Symfony2, the UseCaseBundle is more appropriate.

UseCaseProxy can be instantiate as following:
```php

class app()
{
    /**
     * @var OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxyBuilder
     */
    private $builder;   
    
    /**
     * @var OpenClassrooms\UseCase\Application\Services\Security\Security;
     */
    private $security;
    
    /**
     * @var OpenClassrooms\Cache\Cache\Cache; 
     */
    private $cache;
    
    /**
     * @var OpenClassrooms\UseCase\Application\Services\Transaction\Transaction;
     */
    private $transaction;
    
    /**
     * @var OpenClassrooms\UseCase\Application\Services\EventSender\EventSender;
     */
    private $event;
    
    /**
     * @var OpenClassrooms\UseCase\Application\Services\EventSender\EventFactory
     */
    private $eventFactory;
    
    /**
     * @var Psr\Log\LoggerInterface
     */
     private $logger;

    /**
     * @var Doctrine\Common\Annotations\Reader
     */
    private $reader;

    public function method()
    {
        $useCase = $this->builder
                    ->create(new OriginalUseCase())
                    ->withReader($this->reader)
                    ->withSecurity($this->security)
                    ->withCache($this->cache)
                    ->withTransaction($this->transaction)
                    ->withEventSender($this->event)
                    ->withEventFactory($this->eventFactory)
                    ->withLogger($this->logger)
                    ->build();
    }                    
}                
```
Only ```UseCaseProxyBuilder::create(UseCase $useCase)``` and ```UseCaseProxyBuilder::withReader(AnnotationReader $reader)``` are mandatory.

## Usage
A classic Use Case in Clean / Hexagonal / Use Case Architecture style looks like this:

```php

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

class AUseCase implements UseCase
{
    /**
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        // do things
        
        return $useCaseResponse;
    }
}
```
The library provides a Proxy of the UseCase.

### Security
@Security annotation allows to check access.

```php

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\UseCase\Application\Annotations\Security;

class AUseCase implements UseCase
{
    /**
     * @Security (roles = "ROLE_1")
     *
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        // do things
        
        return $useCaseResponse;
    }
}
```
"roles" is mandatory.

Other options :
```php
/**
 * @Security (roles = "ROLE_1, ROLE_2")
 * Check the array of roles
 *
 * @Security (roles = "ROLE_1", checkRequest = true)
 * Check access for the object $useCaseRequest
 *
 * @Security (roles = "ROLE_1", checkField = "fieldName")
 * Check access for the field "fieldName" of the object $useCaseRequest
 */
```

### Cache
@Cache annotation allows to manage cache.

```php

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\UseCase\Application\Annotations\Cache;

class AUseCase implements UseCase
{
    /**
     * @Cache
     *
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        // do things
        
        return $useCaseResponse;
    }
}
```
The key is equal to : ```md5(serialize($useCaseRequest))``` and the TTL is the default one.

Other options:
```php
/**
 * @Cache (lifetime=1000)
 * Add a TTL of 1000 seconds
 *
 * @Cache (namespacePrefix="namespace_prefix")
 * Add a namespace to the id with a namespace id equals to "namespace_prefix" 
 *
 * @Cache (namespacePrefix="namespace prefix", namespaceAttribute="fieldName")
 * Add a namespace to the id with a namespace id equals to "namespace_prefix" . "$useCaseRequest->fieldName"
 */
```
### Transaction

@Transaction annotation gives a transactional context around the Use Case.
- begin transaction
- execute()
- commit
- rollback on exception
 

```php

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\UseCase\Application\Annotations\Transaction;

class AUseCase implements UseCase
{
    /**
     * @Transaction
     *
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        // do things
        
        return $useCaseResponse;
    }
}
```
### Event

@Event annotation allows to send events.

An implementation of OpenClassrooms\UseCase\Application\Services\EventSender\EventFactory must be written in the application context.

```php
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\UseCase\Application\Annotations\EventSender;

class AUseCase implements UseCase
{
    /**
     * @Event
     *
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        // do things
        
        return $useCaseResponse;
    }
}
```

The message can be send:
- pre execute
- post execute
- on exception
or all of them.

Post is default.

The name of the event is the name of the use case with underscore, prefixed by the method.
For previous example, the name would be : use_case.post.a_use_case

Prefixes can be :
- use_case.pre.
- use_case.post.
- use_case.exception.

```php
/**
 * @Event(name="event_name")
 * Send an event with event name equals to *prefix*.event_name
 * (note: the name is always converted to underscore)
 *
 * @Event(methods="pre")
 * Send an event before the call of UseCase->execute()
 *
 * @Event(methods="pre, post, onException")
 * Send an event before the call of UseCase->execute(), after the call of UseCase->execute() or on exception
 * 
 * @Event(name="first_event")
 * @Event(name="second_event")
 * Send two events
 */
```

### Log

@Log annotation allows to add log following the [PSR standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md).


```php
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\UseCase\Application\Annotations\Log;

class AUseCase implements UseCase
{
    /**
     * @Log
     *
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        // do things
        
        return $useCaseResponse;
    }
}
```

The log can be:
- pre execute
- post execute
- on exception
or all of them.

On exception is default.

Level can be specified following [PSR's levels](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md#5-psrlogloglevel).
Warning is default.


```php
/**
 * @Log(level="error")
 * Log with the level 'error'
 * 
 * @Log (message="message with context {foo}", context={"foo":"bar"})
 * Log with standard message
 *
 * @Log(methods="pre")
 * Log before the call of UseCase->execute()
 *
 * @Log(methods="pre, post, onException")
 * Log before the call of UseCase->execute(), after the call of UseCase->execute() or on exception
 * 
 * @Log(methods="pre", level="debug")
 * @Log(methods="onException", level="error")
 * Log before the call of UseCase->execute() with debug level and on exception with error level
 */
```


### Workflow
The execution order is the following:

Pre Excecute:
- log (pre)
- security
- cache (fetch)
- transaction (begin transaction)
- event (pre)

Post Excecute:
- cache (save if needed)
- transaction (commit)
- event (post)
- log (post)

On Exception:
- log (on exception)
- transaction (rollback)
- event (on exception)

### Utils
The library provide a generic response for paginated collection.
