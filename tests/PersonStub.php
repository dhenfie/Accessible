<?php

namespace Tests;

class PersonStub
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

    private function getPerson(array $person, string $message): string
    {
        return implode(' ', $person).' '.$message;
    }

    public function getMessage(string $message): string
    {
        return $message.' '.$this->name;
    }
}