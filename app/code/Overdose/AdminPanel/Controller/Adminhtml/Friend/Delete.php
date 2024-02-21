<?php

namespace Overdose\AdminPanel\Controller\Adminhtml\Friend;

class Delete extends Index
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        $adminPage = $this->resultFactory->create('page');
        $adminPage->getConfig()->getTitle()->prepend(__('Delete Friend'));

        return $adminPage;
    }
}
