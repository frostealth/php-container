PHP Container
====================

Example
-------
```php
<?php

use frostealth\Container\Container;

$container = new Container();

// ...

// injecting simple values
$container->set('foo', 'bar'); // or $container->foo = 'bar';

// get its value
$value = $container->get('foo');  // or $value = $container->foo;

// ...

// resources 
$container->set('object', function ($container) {
    return new MyObject($container->foo);
});

// get a new instance
$object = $container->get('object');

// ...

// singleton resources
$container->singleton('log', function ($container) {
    return new MyLog($container->object);
});

// get log resource
$log = $container->get('log');
```

Requirements
------------
* PHP >= 5.4
