<?php

namespace Alex\RequestSample\Controller\Customer;

use Alex\RequestSample\Api\Data\RequestSampleInterface;
use Alex\RequestSample\Api\RequestSampleRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;

class SampleRequests extends Action
{

    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->set(__('My responses for Sample Requests'));
        $this->_view->renderLayout();
    }
}
