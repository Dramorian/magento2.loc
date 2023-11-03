<?php

namespace Alex\Homework11\Model;

use ReflectionClass;
use ReflectionMethod;

class DisplayConstantsAndMethods
{

    public const FIRST = 'First const';
    public const SECOND = 'Second const';
    public const THIRD = 'Third const';


    public function displayInfo()
    {
        $reflection = new ReflectionClass($this);

        // Get constants from the current class and its parents
        $constants = [];
        $class = $reflection;
        do {
            $constants[$class->getName()] = $class->getConstants();
        } while ($class = $class->getParentClass());

        // Display names and values of all constants
        echo "Constants:\n";
        foreach ($constants as $class => $classConstants) {
            echo "Class: $class\n";
            foreach ($classConstants as $name => $value) {
                echo "$name => $value\n";
            }
        }

        // Display names of all public methods
        echo "\nPublic Methods:\n";
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            echo $method->getName() . "\n";
        }
    }
}

