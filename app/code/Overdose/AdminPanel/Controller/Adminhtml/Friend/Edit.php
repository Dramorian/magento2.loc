<?php

namespace Overdose\AdminPanel\Controller\Adminhtml\Friend;

class Edit extends Index
{
    public function execute()
    {
        $adminPage = $this->resultFactory->create('page');
        $adminPage->getConfig()->getTitle()->prepend(__('Aloha'));

        return $adminPage;
    }
}
