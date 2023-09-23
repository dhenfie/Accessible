### About
A simple utility that allows accessing a private or protected method outside the class.

###  Install
install via Composer 
```bash
composer require dhenfie/accessible 
```

### Usage
Use the static method `inspect()` from the `Accessible` class to introspect a target object, and afterward, you can call private methods as you would normally.

#### **Example**
```php
<?php
require 'vendor/autoload.php';

$person = new Person();
$inspect = \Dhenfie\Accessible\Accessible::inspect($person);

// call private method setName() in object Person
$inspect->setName('Tailor Otwell');

// call public method getName() in object person
echo  $person->getName(); // Taylor Otwell
```
