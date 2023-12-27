<?php

namespace Alex\AskQuestion\Controller\Adminhtml\Question;

use Alex\AskQuestion\Model\AskQuestionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Block\Page;
use Magento\Framework\Controller\ResultFactory;

class Delete extends Action
{
    /**
     * @var AskQuestionFactory
     */
    protected $askQuestionFactory;

    /**
     * Delete action constructor
     *
     * @param Context $context
     * @param AskQuestionFactory $askQuestionFactory
     */
    public function __construct(
        Context            $context,
        AskQuestionFactory $askQuestionFactory
    ) {
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
                $model->load($id);

                // Retrieve the data from the model
                $data = $model->getData();

                if (!empty($data)) {
                    $model->delete();
                    $this->messageManager->addSuccessMessage(__('The question has been deleted.'));
                } else {
                    $this->messageManager->addErrorMessage(__('Unable to find the question to delete.'));
                }
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('askquestion/question/index');
    }
}
