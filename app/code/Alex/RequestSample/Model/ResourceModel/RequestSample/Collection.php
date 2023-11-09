<?php

namespace Alex\RequestSample\Model\ResourceModel\RequestSample;

use Alex\RequestSample\Model\RequestSample;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            RequestSample::class,
            \Alex\RequestSample\Model\ResourceModel\RequestSample::class
        );
    }
}
