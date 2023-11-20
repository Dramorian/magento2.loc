<?php

namespace Alex\AskQuestion\Model\ResourceModel\AskQuestion;

use Alex\AskQuestion\Model\AskQuestion;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            AskQuestion::class,
            \Alex\AskQuestion\Model\ResourceModel\AskQuestion::class
        );
    }
}
