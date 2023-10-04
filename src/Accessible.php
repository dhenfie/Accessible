<?php

namespace Dhenfie\Accessible;

use BadMethodCallException;
use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

class Accessible
{

    /**
     * Instance of ReflectionClass
     * @var ReflectionClass
     */
    private ReflectionClass $reflectionClass;

    /**
     * Target Object
     * @var object
     */
    private object $instanceObject;

    /**
     * Create Accessible object
     * @param  object  $instanceObject
     */
    public function __construct(object $instanceObject)
    {
        $this->instanceObject = $instanceObject;
        $this->reflectionClass = new ReflectionClass($this->instanceObject);
    }

    /**
     * Inspected the target object and return instance of ReflectionMethod
     *
     * @param  string  $method
     * @return ReflectionMethod|null
     * @throws ReflectionException
     */
    private function inspectorMethod(string $method): ?ReflectionMethod
    {
        $inspector = $this->reflectionClass->getMethod($method);
        return !$inspector->isPublic() ? $inspector : null;
    }

    /**
     * Inspected the target object and return instance of ReflectionProperty
     *
     * @param  string  $property
     * @return ReflectionProperty|null
     * @throws ReflectionException
     */
    private function inspectorProperty(string $property): ?ReflectionProperty
    {
        $inspector = $this->reflectionClass->getProperty($property);
        return !$inspector->isPublic() ? $inspector : null;
    }

    /**
     * @param  string  $name
     * @return string
     * @throws Exception
     */
    public function __get(string $name)
    {
        try {
            $inspector = $this->inspectorProperty($name);
            if ($inspector !== null) {
                return $inspector->getValue($this->instanceObject);
            } else {
                return sprintf('the %s is a public property and can call it as normally.', $name);
            }
        } catch (ReflectionException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function __set(string $name, $value): void
    {
        try {
            $inspector = $this->inspectorProperty($name);
            $inspector?->setValue($this->instanceObject, $value);
        } catch (ReflectionException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * Call private or protected method on target object
     */
    public function __call(string $name, array $arguments)
    {
        try {
            $inspector = $this->inspectorMethod($name);
            if ($inspector !== null) {
                return $inspector->invokeArgs($this->instanceObject, $arguments);
            } else {
                return sprintf('The %s() is a public method and you can call it as normally', $name);
            }
        } catch (ReflectionException $exception) {
            throw new BadMethodCallException($exception->getMessage());
        }
    }

    /**
     * Inspect target object and return Accessible instance
     *
     * @param  object  $object
     * @return self
     */
    public static function inspect(object $object): self
    {
        return (new self($object));
    }
}