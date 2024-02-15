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
        if ($this->getRequest()->isPost()) {
            $friendIdToRetrieve = $this->getRequest()->getPost('friendId');

// Perform validation on the entered friend ID (add your validation logic here)
            if (!ctype_digit((string)($friendIdToRetrieve))) {
                $this->messageManager->addErrorMessage(__('Please enter a valid numeric friend ID.'));
            } else {
// Retrieve friend's name and age using injected ViewModel
                $friendName = $this->viewModel->getFriendName((int)$friendIdToRetrieve);
                $friendAge = $this->viewModel->getFriendAge((int)$friendIdToRetrieve);

// Display results
                if ($friendName !== null) {
                    $this->messageManager->addSuccessMessage('Friend\'s Name: ' . $friendName);
                } else {
                    $this->messageManager->addErrorMessage('Friend\'s Name not found');
                }

                if ($friendAge !== null) {
                    $this->messageManager->addSuccessMessage('Friend\'s Age: ' . $friendAge);
                } else {
                    $this->messageManager->addErrorMessage('Friend\'s Age not found');
                }
            }
        }

// Load the page layout
        return $this->resultPageFactory->create();
    }
}
