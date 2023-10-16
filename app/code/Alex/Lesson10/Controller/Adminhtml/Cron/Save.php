<?php

namespace Alex\Lesson10\Controller\Adminhtml\Cron;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;

class Save extends Action
{
    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        /** Get data from request */
        $requestData = $this->getRequest()->getPostValue();

        /** Validate and save data */

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/index');
    }
}
