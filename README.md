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
### Instantiation
### Security
@security annotation allows to check access.
"roles" is mandatory.

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
### Transaction

Transaction give a transactional context around the Use Case.
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

