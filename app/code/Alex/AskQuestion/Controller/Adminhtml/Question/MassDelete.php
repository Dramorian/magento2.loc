<?php

namespace Alex\AskQuestion\Controller\Adminhtml\Question;

use Alex\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action
{
    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @var Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * Dependency Initialization
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context           $context,
        Filter            $filter,
        CollectionFactory $collectionFactory
    )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Provides content
     *
     * @return Page
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $count = 0;
            foreach ($collection as $model) {
                $model->delete();
                $count++;
            }
            $this->messageManager->addSuccessMessage(__('A total of %1 question(s) have been deleted.', $count));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('askquestion/question/index');
    }

//    /**
//     * Check Authorization
//     *
//     * @return boolean
//     */
//    public function _isAllowed()
//    {
//        return $this->_authorization->isAllowed('Alex_AskQuestion::delete');
//    }
}
