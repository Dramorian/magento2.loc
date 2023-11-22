<?php

namespace Alex\AskQuestion\Controller\Adminhtml\Question;

use Alex\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;

class MassStatus extends Action implements HttpPostActionInterface
{
    /**
     * @var Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context           $context,
        Filter            $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Update status
     *
     * @return Redirect
     * @throws LocalizedException|Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $status = $this->getRequest()->getParam('status');


        foreach ($collection as $item) {
            $item->setStatus($status);
            $item->save();
        }

        $this->messageManager->addSuccessMessage(__(
            'A total of %1 record(s) have been modified.',
            $collection->getSize()
        ));

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/index');
    }
}
