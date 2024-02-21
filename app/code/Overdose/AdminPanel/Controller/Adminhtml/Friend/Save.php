<?php

namespace Overdose\AdminPanel\Controller\Adminhtml\Friend;

class Save extends Index
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        $adminPage = $this->resultFactory->create('page');
        $adminPage->getConfig()->getTitle()->prepend(__('Save Friend'));

        return $this->_redirect('*/*/');
    }
}
