<?php

namespace Alex\Homework11\Model;

use ReflectionClass;
use ReflectionMethod;

class DisplayConstantsAndMethods
{
    public const FIRST = "First";

    /**
     * @return array
     */
    public function getConstants(): array
    {
        return (new ReflectionClass($this))->getConstants();
    }

    /**
     * @return array
     */
    public function getMethodNames(): array
    {
        $reflection = new ReflectionClass($this);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

        $methodNames = [];
        foreach ($methods as $method) {
            $methodNames[] = $method->name;
        }

        return $methodNames;
    }
}
