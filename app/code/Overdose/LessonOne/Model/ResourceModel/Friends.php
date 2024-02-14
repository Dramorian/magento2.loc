<?php

namespace Overdose\LessonOne\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Friends extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('overdose_lesson_one', 'id');
    }
}
