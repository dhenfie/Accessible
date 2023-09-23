<?php

namespace Tests;

use BadMethodCallException;
use Dhenfie\Accessible\Accessible;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;

class AccessibleTest extends TestCase
{

    public function test_inspect()
    {
        $inspect = Accessible::inspect(new PersonStub('Taylor', 23));
        self::assertInstanceOf(Accessible::class, $inspect);
    }

    public function test_inspector()
    {
        $accessible = Accessible::inspect(new PersonStub('Taylor', 23));
        $inspect = new ReflectionClass($accessible);
        $inspectorMethod = $inspect->getMethod('inspector');

        self::assertFalse($inspectorMethod->invoke($accessible, 'getMessage'), 'Return must false if public method');
        self::assertInstanceOf(ReflectionMethod::class, $inspectorMethod->invoke($accessible, 'getName'),
            'Return must instance of ReflectionMethod if private method');

    }

    public function test_invoke_magic_method()
    {
        $person = new PersonStub('Taylor Otwell', 23);
        self::assertEquals('Taylor Otwell', Accessible::inspect($person)->getName());
        self::assertEquals('Taylor Otwell Hay', Accessible::inspect($person)->getPerson(['Taylor', 'Otwell'], 'Hay'));
    }

    public function test_call_public_method()
    {
        self::expectException(BadMethodCallException::class);
        Accessible::inspect(new PersonStub('taylor', 23))->getMessage('Hello');
    }

    public function test_call_undefined_method()
    {
        self::expectException(BadMethodCallException::class);
        Accessible::inspect(new PersonStub('taylor', 23))->undefined();
    }
}