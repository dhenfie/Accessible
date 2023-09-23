<?php

namespace Tests;

use BadMethodCallException;
use Dhenfie\Accessible\Accessible;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class AccessibleTest extends TestCase
{

    public Accessible $accessible;
    private Person $person;

    protected function setUp(): void
    {
        $this->person = new Person('Fajar Susilo', 23);
        $this->accessible = new Accessible($this->person);
    }

    public function test_inspector()
    {
        $reflection = new ReflectionClass($this->accessible);
        $method = $reflection->getMethod('inspector');
        $method->invoke($this->accessible);
        $inspector = $reflection->getProperty('reflectionMethod')->getValue($this->accessible);

        self::assertCount(2, $inspector);
    }

    public function test_invoke_magic_method(){
        self::assertEquals('Fajar Susilo', $this->accessible->getName('sss'));
        self::assertEquals(23, $this->accessible->getAge());
    }

    public function test_allow(){
       self::assertEquals('Fajar Susilo',  Accessible::allow($this->person)->getName());
    }

    public function test_call_public_method(){
        self::assertEquals('Hello Fajar Susilo', Accessible::allow($this->person)->getMessage('Hello'));
    }

    public function test_call_undefined_method(){
        self::expectException(BadMethodCallException::class);
        Accessible::allow($this->person)->undefined();
    }
}