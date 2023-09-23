<?php

namespace Dhenfie\Accessible;

use BadMethodCallException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

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
     * @param  string  $method
     * @return ReflectionMethod|bool
     */
    private function inspector(string $method): ReflectionMethod|bool
    {
        try {
            $reflectionMethod = $this->reflectionClass->getMethod($method);
            if (!$reflectionMethod->isPublic()) {
                return $reflectionMethod;
            }
            // prevent public method a invoked
            return false;
        } catch (ReflectionException $exception) {
            // Method not found
            return false;
        }
    }

    /**
     * Call private or protected method on target object
     * @throws ReflectionException
     */
    public function __call(string $name, array $arguments)
    {
        if ($inspector = $this->inspector($name)) {
            return $inspector->invokeArgs($this->instanceObject, $arguments);
        }
        throw new BadMethodCallException('Method not found or method is public');
    }

    /**
     * Inspect target object and return Accessible instance
     * @param  object  $object
     * @return self
     */
    public static function inspect(object $object): self
    {
        return (new self($object));
    }
}