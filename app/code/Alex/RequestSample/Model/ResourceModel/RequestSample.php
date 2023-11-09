<?php

namespace Alex\RequestSample\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class RequestSample extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('alex_request_sample', 'request_id');
    }
}
