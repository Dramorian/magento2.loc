<?php

namespace Overdose\LessonOne\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Overdose\LessonOne\ViewModel\One;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var One
     */
    private $viewModel;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param One $viewModel
     */
    public function __construct(
        Context     $context,
        PageFactory $resultPageFactory,
        One         $viewModel
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->viewModel = $viewModel;
    }

    /**
     * Execute action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        // Check if the form is submitted
        if ($this->getRequest()->isPost()) {
            $friendId = $this->getRequest()->getPost('friendId');

            if ($friendId) {
                // Get friend's name and age from ViewModel
                $friendName = $this->viewModel->getFriendName((int)$friendId);
                $friendAge = $this->viewModel->getFriendAge((int)$friendId);

                // Display results
                if ($friendName && $friendAge !== null) {
                    $this->messageManager->addSuccessMessage('Friend\'s name: ' . $friendName);
                    $this->messageManager->addSuccessMessage('Friend\'s age: ' . $friendAge);
                } else {
                    $this->messageManager->addWarningMessage('Enter valid friend id');
                    $this->messageManager->addErrorMessage('Friend\'s name not found');
                    $this->messageManager->addErrorMessage('Friend\'s age not found');
                }
            }
        }

        // Load the page layout
        return $this->resultPageFactory->create();
    }
}
