<?php

namespace Dhenfie\Accessible;

use BadMethodCallException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

final class Accessible
{

    /**
     * List of available methods
     * @var ReflectionMethod[]
     */
    private array $reflectionMethod;

    /**
     * ReflectionClass instance
     * @var ReflectionClass
     */
    private ReflectionClass $reflectionClass;

    /**
     * Object target
     * @var object
     */
    private object $instanceObject;

    /**
     * Create the instance `Accessible`
     * @param  object  $instanceObject
     */
    public function __construct(object $instanceObject)
    {
        $this->instanceObject = $instanceObject;
        $this->reflectionClass = new ReflectionClass($instanceObject);
        $this->inspector();
    }

    /**
     * Inspect object
     * @return void
     */
    private function inspector(): void
    {
        if ($methods = $this->reflectionClass->getMethods(ReflectionMethod::IS_PRIVATE | ReflectionMethod::IS_PROTECTED)) {
            foreach ($methods as $method) {
                $this->reflectionMethod[$method->name] = $method;
            }
        }
    }

    /**
     * @throws ReflectionException
     * @throws BadMethodCallException
     */
    public function __call(string $name, array $arguments): mixed
    {
        if (array_key_exists($name, $this->reflectionMethod)) {
            return $this->reflectionMethod[$name]->invoke($this->instanceObject, $arguments);
        } else {
            if (method_exists($this->instanceObject, $name)) {
                return call_user_func_array([$this->instanceObject, $name], $arguments);
            } else {
                throw new BadMethodCallException(sprintf('Call undefined method %s()', $name));
            }
        }
    }

    /**
     * Create the instance `Accessible`
     * @param  object  $object
     * @return self
     */
    public static function allow(object $object): self
    {
        return (new self($object));
    }

    /**
     * Return all private and protected method
     * @return ReflectionMethod[]
     */
    public function getMethod(): array
    {
        return $this->reflectionMethod;
    }

    /**
     * Return all method
     * @return ReflectionMethod[]
     */
    public function getMethods(): array
    {
        return $this->reflectionClass->getMethods();
    }
}