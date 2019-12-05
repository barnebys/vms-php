
[![Build Status](https://travis-ci.org/barnebys/vms-php.svg?branch=master)](https://travis-ci.org/barnebys/vms-php)

# VMS PHP SDK

The VMS PHP library provides convenient access to the VMS API from application written in the 
PHP language. It includes a set of pre-defined classes for API resources that initialize 
themselves dynamically from API responses.

## Requirements

PHP 7.2.0 or later

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require barnebys/vms
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Getting started

Simple usage looks something like:
```php
\Vms\Vms::setApiKey($apiKey');

$valuations = Vms\Valuation::all();
```
## Examples

See the [examples directory](examples) in this repository.

## Documentation

See the [API Docs](https://backend-docs.vms.sh)



