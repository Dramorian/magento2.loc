<?php

declare(strict_types=1);

namespace Overdose\LessonOne\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class One implements ArgumentInterface
{
    /**
     * @return string
     */
    public function iAmViewModel(): string
    {
        return 'Text from view model';
    }
}
