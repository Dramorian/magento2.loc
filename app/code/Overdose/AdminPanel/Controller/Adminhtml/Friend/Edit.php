<?php

namespace Overdose\AdminPanel\Controller\Adminhtml\Friend;

use Magento\Framework\Controller\ResultFactory;

class Edit extends Index
{
    public function execute()
    {
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $page->getConfig()->getTitle()->prepend(__("New Friend"));
        return $page;
    }
}
