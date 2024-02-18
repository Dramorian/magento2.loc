<?php

namespace Overdose\LessonOne\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\AlreadyExistsException;
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
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     * @param One         $viewModel
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
     * @return \Magento\Framework\App\ResponseInterface|ResultInterface|\Magento\Framework\View\Result\Page
     * @throws AlreadyExistsException
     */
    public function execute()
    {
        $friendId = $this->getRequest()->getParam('friendId');
        $friendCount = $this->getRequest()->getParam('friendCount');

        // Check if the first form is submitted
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

        // Check if the second form is submitted
        if ($friendCount !== null) {
            // Validate and ensure friendCount is within reasonable limits
            if ($friendCount > 0 && $friendCount <= 100) {
                // Call the saveNewFriend method with the desired friend count
                $this->viewModel->saveNewFriend($friendCount);
            } else {
                $this->messageManager->addErrorMessage('Friend generation failed. Enter valid number of friends');
            }
        }

        // Load the page layout
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Friends'));
        return $resultPage;
    }
}
