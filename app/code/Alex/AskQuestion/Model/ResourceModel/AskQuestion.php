<?php

namespace Alex\AskQuestion\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class AskQuestion extends AbstractDb
{
    private const TABLE_NAME = 'alex_ask_question';
    private const PRIMARY_KEY = 'question_id';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::PRIMARY_KEY);
    }
}
