<?php

namespace Alex\Lesson11;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
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
    public function publicContent()
    {
        return "Public Test Content";

    }
}
