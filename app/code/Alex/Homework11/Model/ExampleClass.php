<?php

use Alex\Homework11\Model\DisplayConstantsAndMethods;

class ExampleClass extends DisplayConstantsAndMethods
{
    public const EXAMPLE_CONSTANT = 'Const for child class';

    public function ChildMethod(): string
    {
        return "child method";
    }

    public function anotherChildMethod(): string
    {
        return "another child method";
    }
}

$example = new ExampleClass();
$example->displayInfo();
