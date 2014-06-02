UseCase
=================
[![Build Status](https://travis-ci.org/OpenClassrooms/UseCase.svg?branch=master)](https://travis-ci.org/OpenClassrooms/UseCase)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/5b05eef1-7457-434e-8a8c-44013a6675a1/mini.png)](https://insight.sensiolabs.com/projects/5b05eef1-7457-434e-8a8c-44013a6675a1)
[![Coverage Status](https://coveralls.io/repos/OpenClassrooms/UseCase/badge.png?branch=master)](https://coveralls.io/r/OpenClassrooms/UseCase?branch=master)

Use Case is a library that manage technical code over a Use Case.
- Security access
- Cache management
- Transactional context
- Events

The goal is to have only functional code on the Use Case.

More details on :
- [Clean Architecture](http://blog.8thlight.com/uncle-bob/2012/08/13/the-clean-architecture.html).
- [Hexagonal Architecture](http://alistair.cockburn.us/Hexagonal+architecture).
- [Use Case Driven Development](http://www.ivarjacobson.com/Use_Case_Driven_Development/).

## Installation
The easiest way to install UseCase is via [composer](http://getcomposer.org/).

Create the following `composer.json` file and run the `php composer.phar install` command to install it.

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
                    ->withEvent($this->event)
                    ->withEventFactory($this->eventFactory)
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

class OriginalUseCase implements UseCase
{
    /**
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        // do things
        
        /** @var UseCaseResponse $useCaseResponse */
        return $useCaseResponse;
    }
}
```
The library provides a Proxy of the UseCase.

### Security
@security annotation allows to check access.

```php

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\UseCase\Application\Annotations\Security;

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

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\UseCase\Application\Annotations\Cache;

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

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\UseCase\Application\Annotations\Transaction;

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

An implementation of OpenClassrooms\UseCase\Application\Services\EventSender\EventFactory must be written in the application context.

```php
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\UseCase\Application\Annotations\EventSender;

class MyUseCase implements UseCase
{
    /**
     * @event
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        // do things
    }
}
```

The sent of the message can be :
- pre execute
- post execute
- on exception
or both of them.

Post is default.

The name of the event is the name of the use case with underscore, prefixed by the method.
For previous example, the name would be : use_case.post.my_use_case

Prefixes can be :
- use_case.pre.
- use_case.post.
- use_case.exception.

```php
/**
 * @event(name="event_name")
 * Send a event with event name equals to *prefix*.event_name
 * (note: the name is always converted to underscore)
 *
 * @event(methods="pre")
 * Send a event before the call of UseCase->execute()
 *
 * @event(methods="pre, post, onException")
 * Send a event before the call of UseCase->execute(), after the call of UseCase->execute() or on exception
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

