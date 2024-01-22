<?php

namespace Alex\RequestSample\Observer;

use Magento\Customer\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;

class LayoutGenerateBlocksAfter implements ObserverInterface
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @param Registry $registry
     * @param Session $customerSession
     */
    public function __construct(
        Registry $registry,
        Session  $customerSession
    ) {
        $this->registry = $registry;
        $this->customerSession = $customerSession;
    }

    /**
     * @param Observer $observer
     * @return LayoutGenerateBlocksAfter
     */
    public function execute(Observer $observer)
    {
        $product = $this->registry->registry('current_product');

        if (!$product) {
            return $this;
        }

        if ($this->requestFormDisallowed()) {
            $layout = $observer->getLayout();
            $sampleRequestBlock = $layout->getBlock('request.sample.tab');
            if ($sampleRequestBlock) {
                $sampleRequestBlock->setTemplate('');
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    private function requestFormDisallowed()
    {
        return !$this->customerSession->getCustomer()->getAllowRequestSample();
    }
}
