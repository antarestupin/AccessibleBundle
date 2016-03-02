# AccessibleBundle

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/14520d55-b261-4493-be8a-dae6acde74a6/mini.png)](https://insight.sensiolabs.com/projects/14520d55-b261-4493-be8a-dae6acde74a6)
[![Latest Stable Version](https://poser.pugx.org/antares/accessible-bundle/v/stable)](https://packagist.org/packages/antares/accessible-bundle)
[![License](https://poser.pugx.org/antares/accessible/license)](https://packagist.org/packages/antares/accessible-bundle)

AccessibleBundle provides an [Accessible](https://github.com/antares993/Accessible) integration for your Symfony projects. This will allow you to define your class behavior using powerful annotations.

Here is a (very) basic example:

```php
class Customer
{
  use AutomatedBehaviorTrait;
  
  /**
   * @Access({Access::GET, Access::SET})
   * @Assert\Email
   */
  private $email;
}


$bob = new Customer();

$bob->setEmail('bob@example.com');
$bob->getEmail(); // bob@example.com
$bob->setEmail('not an email address'); // throws an InvalidArgumentException
```

Here the library is used to generate getters and setters, but it can also be used to manage constructors, attributes initialization, collections and associations between classes!

## Documentation

This file contains everything you will need to use this bundle. For details on the use of the library, see the [Accessible page](https://github.com/antares993/Accessible).

## Installation

First add the bundle in your Composer dependencies:

```php
composer require antares/accessible-bundle
```

Then, register the bundle in your kernel:

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...

        new Antares\Bundle\AccessibleBundle\AntaresAccessibleBundle()
    );
}
```

## Configuration

The configuration of this bundle is quite simple, take a look:

```yaml
# app/config/config.yml
antares_accessible:
    cache.enable: true # default: false
    constraints_validation.validate_initialize_values: true # default: %kernel.debug%
```

Here are the meanings of the configuration values:
- `cache.enable`: Do you want a cache driver to be used?
- `constraints_validation.validate_initialize_values`: Do you want the `@Initialize` and `@InitializeObject` values to be validated?

### Use a custom cache driver

By default, instances of `Doctrine\Common\Cache\PhpFileCache` are used. If you have APC enabled, you should replace the cache driver. You can do it like this:

```php
# app/config/services.yml

parameters:
    antares_accessible.cache_driver.class: Doctrine\Common\Cache\ApcCache

services:
    antares_accessible.cache.driver:
        class: "%antares_accessible.cache_driver.class%"
    antares_accessible.annotations.cache_driver:
        class: "%antares_accessible.cache_driver.class%"
```

- `antares_accessible.cache.driver` is the cache driver used by the library
- `antares_accessible.annotations.cache_driver` is the cache driver used by the library's annotation reader

### Use a custom annotations reader

You can use a custom annotations reader:

```php
# app/config/services.yml

services:
    antares_accessible.annotations.reader:
        class: Doctrine\Common\Annotations\AnnotationReader
```

### Use a custom validator

You can also use a custom constraints validator, for example, if your project already uses the validator service, you can use it also with this library like this:

```php
# app/config/services.yml

services:
    antares_accessible.constraints_validation.validator: '@validator'
```
