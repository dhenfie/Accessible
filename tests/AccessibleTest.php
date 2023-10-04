<?php

namespace Tests;

use BadMethodCallException;
use Dhenfie\Accessible\Accessible;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use function Dhenfie\Accessible\accessible;

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
        $inspectorMethod = $inspect->getMethod('inspectorMethod');

        self::assertNull($inspectorMethod->invoke($accessible, 'getMessage'));
        self::assertInstanceOf(ReflectionMethod::class, $inspectorMethod->invoke($accessible, 'getName'),);

    }

    public function test_invoke_magic_method()
    {
        $person = new PersonStub('Taylor Otwell', 23);
        self::assertEquals('Taylor Otwell', Accessible::inspect($person)->getName());
        self::assertEquals('Taylor Otwell Hay', Accessible::inspect($person)->getPerson(['Taylor', 'Otwell'], 'Hay'));
    }

    public function test_call_public_method()
    {
        $actual = Accessible::inspect(new PersonStub('taylor', 23))->getMessage('Hello');
        self::assertEquals('The getMessage() is a public method and you can call it as normally', $actual);
    }

    public function test_call_undefined_method()
    {
        self::expectException(BadMethodCallException::class);
        Accessible::inspect(new PersonStub('taylor', 23))->undefined();
    }

    public function test_helper(){
        self::assertInstanceOf(Accessible::class, accessible(new class{}));
    }

    public function test_helper_accessible(){
        self::assertEquals('Taylor', accessible(new PersonStub('Taylor', 23))->getName());
    }

    public function test_get_value_property(){
        $person = new PersonStub('Fajar Susilo', 23);
        self::assertEquals('Fajar Susilo', accessible($person)->name);
    }
    public function test_set_value_property(){

        $person = new PersonStub('Fajar Susilo', 23);

        self::assertEquals(23, accessible($person)->age);

        accessible($person)->age = 17;

        self::assertEquals(17, accessible($person)->age);
    }
}