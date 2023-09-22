### About
A simple utility that allows accessing a private or protected method outside the class.

###  Install
install via Composer 
```bash
composer require dhenfie/accessible 
```

### Usage
Use the static method `allow` from the `Accessible` class to introspect a target object, and afterward, you can call private methods as you would normally.

```php
$inspect = \Dhenfie\Accessible\Accessible::allow(new Person());

// call method private setName() in object Person
$inspect->setName('Tailor Otwell');
```

Or call it directly instead of storing it in a variable first.

```php
\Dhenfie\Accessible\Accessible::allow(new Person)->setName();
```
