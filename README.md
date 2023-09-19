### Accessible
A simple utility that allows accessing a private or protected method outside the class.

### Documentation
####  Install
install via Composer 
```bash
composer require dhenfie/accessible --dev
```

#### User Guide
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

#### Usage in Unit Testing
The main benefit of this Utility Tool is for unit testing scenarios. For example, when we want and need to test a method with private and protected access, which cannot be done directly. Considering that private and protected methods have limited scope.

However, in [PHP](https://php.net), there is the [Reflection](https://www.php.net/manual/en/book.reflection.php)  API that allows for introspection and modification of an object and its methods. And, of course, the [Accessible](https://github.com/dhenfie/accessible)  class also utilizes this Reflection API.