<?php

namespace Overdose\AdminPanel\Controller\Adminhtml\Friend;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class NewAction extends Action
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)
    ->forward('edit');
    }
}
