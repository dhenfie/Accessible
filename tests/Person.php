<?php

namespace Tests;

class Person
{
    private string $name;
    private string $age;

    public function __construct(string $name, string $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    private function getName(): string
    {
        return $this->name;
    }

    protected function getAge(): string
    {
        return $this->age;
    }

    public function getMessage(string $message): string {
        return $message. ' '. $this->name;
    }
}