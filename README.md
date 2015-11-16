# AntaresAccessibleBundle

[![License](https://poser.pugx.org/antares/accessible/license)](https://packagist.org/packages/antares/accessible-bundle)

AntaresAccessibleBundle provides an [Accessible](https://github.com/antares993/Accessible) integration for your Symfony projects.

## Installation

First add the bundle in your Composer dependencies:

```php
composer require antares/accessible-bundle dev-master
```

Then register the bundle in your kernel:

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...

        new Antares\Bundle\AntaresAccessibleBundle()
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
    antares_accessible.cache.driver: "%antares_accessible.cache_driver.class%"
    antares_accessible.annotations.cache_driver: "%antares_accessible.cache_driver.class%"
```

- `antares_accessible.cache.driver` is the cache driver used by the library
- `antares_accessible.annotations.cache_driver` is the cache driver used by the library's annotation reader
