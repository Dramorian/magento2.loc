<?php

namespace Alex\Lesson11\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Data extends AbstractHelper implements ArgumentInterface
{
    /**
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * @return string
     */
    public function publicContent(): string
    {
        return "This is a string from helper's public function";
    }
}
