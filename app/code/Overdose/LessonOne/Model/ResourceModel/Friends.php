<?php

namespace Overdose\LessonOne\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Overdose\LessonOne\Api\Data\FriendInterface;

class Friends extends AbstractDb
{
    protected function _construct()
    {
        $this->_init(FriendInterface::TABLE_NAME, FriendInterface::FIELD_NAME_ID);
    }
}
