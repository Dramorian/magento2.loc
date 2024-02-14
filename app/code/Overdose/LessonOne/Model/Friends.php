<?php

namespace Overdose\LessonOne\Model;

use Magento\Framework\Model\AbstractModel;

class Friends extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel\Friends::class);
    }
}
