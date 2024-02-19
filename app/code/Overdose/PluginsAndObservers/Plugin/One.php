<?php

namespace Overdose\PluginsAndObservers\Plugin;

class One
{
    /**
     * @param \Overdose\LessonOne\ViewModel\One $subject
     * @param \Closure $proceed
     * @param $arg1
     * @param $arg2
     * @return string
     */
    public function aroundGetText(\Overdose\LessonOne\ViewModel\One $subject, \Closure $proceed, $arg1, $arg2)
    {
        $x = 1;

        $arg1 = 'Йо';
        $arg2 = 'Ваззап';

        // Before plugin

        $originalFunctionResult = $proceed($arg1, $arg2);

        // 'йо |||| ваззап'

        $originalFunctionResult .= "<- original result || after result ->" . "Здоровенькі були!";

        return $originalFunctionResult;
    }
}
