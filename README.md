### About

A simple utility that allows accessing private methods and private properties outside of the class.

### Install

Install via composer.

```bash
composer require dhenfie/accessible
```

### Usage

Use the `accessible($targetObject)` function to introspect the target object, and after that, you can access private
methods as if they were public methods.

Example:

```php
<?php

use function Dhenfie\Accessible\accessible;

require 'vendor/autoload.php';

$person = new Person(name: 'Fajar Susilo');

// call private method 'getFilterName()'
echo accessible($person)->getFilterName('uppercase');
```

The `accessible()` function can also be used for object properties.

Example:

```php
<?php

use function Dhenfie\Accessible\accessible;

require 'vendor/autoload.php';

$person = new Person(name: 'Fajar Susilo');

// accessing private property '$name'
echo accessible($person)->name;

// set value private property '$name'
accessible($person)->name = 'Taylor Otwell';
```



