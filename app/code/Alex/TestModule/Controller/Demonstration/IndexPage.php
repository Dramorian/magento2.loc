<?php

namespace Alex\TestModule\Controller\Demonstration;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\ResultFactory;

class IndexPage extends \Magento\Framework\App\Action\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $customText = "All my life I thought air was for free. That was until I bought a bag of potato chips.";
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getLayout()->getBlock('custom.test.page.result')->setCustomText($customText);

        return $resultPage;
    }
}
