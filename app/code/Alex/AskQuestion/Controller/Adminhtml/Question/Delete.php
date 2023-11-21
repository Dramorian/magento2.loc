<?php

namespace Alex\AskQuestion\Controller\Adminhtml\Question;

use Alex\AskQuestion\Model\AskQuestionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Delete extends Action
{
    /**
     * @var AskQuestionFactory
     */
    protected $askQuestionFactory;

    /**
     * Dependency Initialization
     *
     * @param Context $context
     * @param AskQuestionFactory $askQuestionFactory
     */
    public function __construct(
        Context            $context,
        AskQuestionFactory $askQuestionFactory
    )
    {
        $this->askQuestionFactory = $askQuestionFactory;
        parent::__construct($context);
    }

    /**
     * Provides content
     *
     * @return Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('question_id');
        if ($id) {
            try {
                $model = $this->askQuestionFactory->create();
                $model->getResource()->load($model, $id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('The question has been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
        } else {
            $this->messageManager->addErrorMessage(__('Unable to find the question to delete.'));
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('askquestion/question/index');
    }
}
