PHP Resource Locator
====================

Example
-------
```php
<?php

use frostealth\Locator\Locator;

$locator = new Locator();

// ...

// injecting simple values
$locator->set('foo', 'bar'); // or $locator->foo = 'bar';

// get its value
$value = $locator->get('foo');  // or $value = $locator->foo;

// ...

// resources 
$locator->set('object', function ($locator) {
    return new MyObject($locator->foo);
});

// get a new instance
$object = $locator->get('object');

// ...

// singleton resources
$locator->singleton('log', function ($locator) {
    return new MyLog($locator->object);
});

// get log resource
$log = $locator->get('log');
```

Note
----
[Use Locator as singleton](https://github.com/frostealth/php-singleton-trait)

Requirements
------------
* PHP >= 5.4
* [PHP Data Storage v1.0](https://github.com/frostealth/php-data-storage/releases)
