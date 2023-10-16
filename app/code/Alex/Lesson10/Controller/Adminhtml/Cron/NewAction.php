<?php

namespace Alex\Lesson10\Controller\Adminhtml\Cron;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class NewAction extends Action
{
    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * NewAction constructor.
     * @param Context $context
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        Context       $context,
        ResultFactory $resultFactory
    ) {
        $this->resultFactory = $resultFactory;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Forward $resultForward */
        $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
        return $resultForward->forward('edit');
    }
}
