<?php

namespace Alex\Homework11\Model;

class ParameterDisplay
{
    /**
     * @var array
     */
    protected array $parameters;

    /**
     * @param  $stringParam
     * @param  $instanceParam
     * @param  $boolParam
     * @param  $intParam
     * @param  $globalInitParam
     * @param  $constantParam
     * @param  $nullParam
     * @param  $arrayParam
     */
    public function __construct(
        $stringParam,
        $instanceParam,
        $boolParam,
        $intParam,
        $globalInitParam,
        $constantParam,
        $nullParam,
        $arrayParam,

    )
    {
        $this->parameters = [
            'stringParam' => $stringParam,
            'instanceParam' => $instanceParam,
            'boolParam' => $boolParam,
            'intParam' => $intParam,
            'globalInitParam' => $globalInitParam,
            'constantParam' => $constantParam,
            'nullParam' => $nullParam,
            'arrayParam' => $arrayParam,
        ];
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        $parametersArray = [];
        foreach ($this->parameters as $name => $value) {
            $parameterValue = is_object($value) ? get_class($value) : $value;
            $parametersArray[$name] = $parameterValue;
        }

        return $parametersArray;
    }
}
