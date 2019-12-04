# VMS PHP SDK

The VMS PHP library provides convenient access to the VMS API from application written in the 
PHP language. It includes a set of pre-defined classes for API resources that initialize 
themselves dynamically from API responses.

## Requirements

PHP 7.2.0 or later

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require barnebys/vms-php
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```


## Manual Installation

TBD

## Getting started

Simple usage looks something like:
```
\Vms\Vms::setApiKey($apiKey');

$valuations = Vms\Valuation::all();
```

## Documentation

See the [API Docs](https://backend-docs.vms.sh)

## Examples

First set you need to set your api key `\Vms\Vms::setApiKey($apiKey');`

### Fetch options

`$options = \Vms\Options::fetch();`

#### Available categories

`$options->categories`

#### Available currencies

`$options->categories`

### Fetch a valuation
`$valuation = \Vms\Valuation::fetch("5d0519851490bb63ec62ae3f");`

### Fetch all valuations (as collection)
`$valuations = \Vms\Valuation::all();`

### Upload a image
`$images = \Vms\Images::create([$myImageFile1, $myImageFile2]);`

### Create a valuation
```
$valuation = \Vms\Valuation::create([
    'title' => 'A painting by Leonardo da Vinci', // string
    'userDescription' => 'Some description', // string
    'category' => $categoryName, // string or \Vms\Category
    'type' => \Vms\Valuation::TYPE_EXPRESS,
    'images' => $images,  // array of filenames or \Vms\Images
    'dimensions' => [
        'width' => 100,
        'height' => 200,
        'length' => 90,
        'depth' => 20,
        'unit' => \Vms\Valuation::UNIT_CM
    ],
    'currency' => $currency // string or \Vms\Currency
]);
```
