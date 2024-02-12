<?php

declare(strict_types=1);

namespace Overdose\LessonOne\Block;

use Magento\Framework\View\Element\Template;

class Overdose extends Template
{
    /**
     * @return string
     */
    public function doSomethingImportant(): string
    {
        return 'Important text from important function from Block';
    }
}
