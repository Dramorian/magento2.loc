<?php

namespace Overdose\LessonOne\Model\ResourceModel\Collection;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Friends extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Overdose\LessonOne\Model\Friends::class,
            \Overdose\LessonOne\Model\ResourceModel\Friends::class);
    }
}
