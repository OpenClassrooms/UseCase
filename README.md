CleanArchitecture
=================
[![Build Status](https://travis-ci.org/OpenClassrooms/CleanArchitecture.svg?branch=master)](https://travis-ci.org/OpenClassrooms/CleanArchitecture)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/5b05eef1-7457-434e-8a8c-44013a6675a1/mini.png)](https://insight.sensiolabs.com/projects/5b05eef1-7457-434e-8a8c-44013a6675a1)

Clean Architecture is a library that manage technical code over a Use Case.
- Security access
- Cache management
- Transactional context
- Events

The goal is to have only functional code on the Use Case.

More details on [Clean Architecture](http://blog.8thlight.com/uncle-bob/2012/08/13/the-clean-architecture.html).

## Installation
The easiest way to install Cache is via [composer](http://getcomposer.org/).

Create the following `composer.json` file and run the `php composer.phar install` command to install it.

```json
{
    "require": {
        "openclassrooms/clean-architecture": "*"
    }
}
```
```php
<?php
require 'vendor/autoload.php';

use OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\UseCaseProxy;

//do things
```
<a name="install-nocomposer"/>

## Usage
A classic Use Case in Clean Architecture looks like this:

```php

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCase;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;

class OriginalUseCase implements UseCase
{
    /**
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        // do things
    }
}
```
The library provides a Proxy of the UseCase.

### Instantiation
The UseCaseProxy needs a lot of dependencies. 

The Dependency Injection Pattern is clearly helpful.

For an implementation with Symfony2, the CleanArchitectureBundle is more appropriate.

UseCaseProxy can be instantiate as following:
```php
use 
class app()
{
    /**
     * @var OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\UseCaseProxyBuilder
     */
    private $builder;   
    
    /**
     * @var OpenClassrooms\CleanArchitecture\Application\Services\Security\Security; 
     */
    private $security;
    
    /**
     * @var OpenClassrooms\Cache\Cache\Cache; 
     */
    private $cache;
    
    /**
     * @var OpenClassrooms\CleanArchitecture\Application\Services\Transaction\Transaction; 
     */
    private $transaction;
    
    /**
     * @var OpenClassrooms\CleanArchitecture\Application\Services\Event\Event; 
     */
    private $event;
    
    /**
     * @var OpenClassrooms\CleanArchitecture\Application\Services\Event\EventFactory
     */
    private $eventFactory;

    /**
     * @var Doctrine\Common\Annotations\Reader
     */
    private $reader;

    public function method()
    {
        $useCase = $this->builder
                    ->forUseCase(new OriginalUseCase())
                    ->withSecurity($this->security)
                    ->withCache($this->cache)
                    ->withTransaction($this->transaction)
                    ->withEvent($this->event)
                    ->withEventFactory($this->eventFactory)
                    ->withReader($this->reader)
                    ->build();
    }                    
}                
```

### Security
@security annotation allows to check access.

```php

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCase;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Security;

class MyUseCase implements UseCase
{
    /**
     * @security (roles = "ROLE_1")
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        // do things
    }
}
```
"roles" is mandatory.

Other options :
```php
/**
 * @security (roles = "ROLE_1, ROLE_2")
 * Check the array of roles
 *
 * @security (roles = "ROLE_1", checkRequest = true)
 * Check access for the object $useCaseRequest
 *
 * @security (roles = "ROLE_1", checkField = "fieldName")
 * Check access for the field "fieldName" of the object $useCaseRequest
 */
```

### Cache
@cache annotation allows to manage cache.

```php

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCase;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Cache;

class MyUseCase implements UseCase
{
    /**
     * @cache
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        // do things
    }
}
```
The key is equal to : ```md5(serialize($useCaseRequest))``` and the TTL is the default one.

Other options:
```php
/**
 * @cache (lifetime=1000)
 * Add a TTL of 1000 seconds
 *
 * @cache (namespacePrefix="namespace_prefix")
 * Add a namespace to the id with a namespace id equals to "namespace_prefix" 
 *
 * @cache (namespacePrefix="namespace prefix", namespaceAttribute="fieldName")
 * Add a namespace to the id with a namespace id equals to "namespace_prefix" . "$useCaseRequest->fieldName"
 */
```
### Transaction

Transaction gives a transactional context around the Use Case.
- begin transaction
- execute()
- commit
- rollback on exception
 
Will use the previous active transaction if there is one.

```php

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCase;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Transaction;

class MyUseCase implements UseCase
{
    /**
     * @transaction
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        // do things
    }
}
```
### Event

@event annotation allows to send events.

An implementation of OpenClassrooms\CleanArchitecture\Application\Services\Event\EventFactory must be written in the application context.

```php

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCase;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Event;

class MyUseCase implements UseCase
{
    /**
     * @event (name="event_name")
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        // do things
    }
}
```
"name" is mandatory.

The sent of the message can be :
- pre execute
- post execute
- on exception
or both of them.

Post is default.

```php
/**
 * @event(name="event_name", methods="pre")
 * Send a event 'event_name' before the call of UseCase->execute()
 *
 * @event(name="event_name", methods="pre, post, onException")
 * Send a event 'event_name' before the call of UseCase->execute(), after the call of UseCase->execute() or on exception
 */
```

### Workflow
The execution order is the following:

Pre Excecute:
- security
- cache (fetch)
- transaction (begin transaction)
- event (pre)

Post Excecute:
- cache (save if needed)
- transaction (commit)
- event (post)

On Exception:
- transaction (rollback)
- event (on exception)

