<?php

namespace Alex\AskQuesiton\Controller\Adminhtml\Question;

use Alex\AskQuestion\Model\AskQuestion;
use Alex\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\Filter;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;

class Edit extends Action
{

    public function __construct(
        Context                            $context,
        private readonly Filter            $filter,
        private readonly CollectionFactory $collectionFactory
    )
    {
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute(): Page|ResultInterface|ResponseInterface
    {

        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        /** @var AskQuestion $question
         */
        foreach ($collection as $question) {
            $question->getStatus();
            $this->resultFactory->save($question);

        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been edited.', $collectionSize));

        $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $result->setPath('*/*/');
    }
}

//        /** Get data from request */
//        $requestData = $this->getRequest()->getPostValue();
//
//        /** Validate and save data */
//
//        /** @var Redirect $resultRedirect */
//        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
//
//        return $resultRedirect->setPath('*/*/index');

