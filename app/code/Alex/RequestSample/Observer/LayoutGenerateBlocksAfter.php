<?php

namespace Alex\RequestSample\Observer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;

class LayoutGenerateBlocksAfter implements ObserverInterface
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $_customerRepositoryInterface;

    /**
     * @var SessionFactory
     */
    protected $_customerSession;

    /**
     * @param Registry $registry
     * @param CustomerRepositoryInterface $customerRepositoryInterface
     * @param SessionFactory $customerSession
     */
    public function __construct(
        Registry                    $registry,
        CustomerRepositoryInterface $customerRepositoryInterface,
        SessionFactory              $customerSession
    )
    {
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->registry = $registry;
        $this->_customerSession = $customerSession;
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

        if ($this->isRequestFormDisallowed()) {
            $layout = $observer->getLayout();
            $sampleRequestBlock = $layout->getBlock('request.sample.tab');
            if ($sampleRequestBlock) {
                $sampleRequestBlock->setTemplate('');
            }
        }

        return $this;
    }

    /**
     * Check attribute value, disable the form if value is set to 0
     *
     * @return bool
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    private function isRequestFormDisallowed(): bool
    {
        $customerSession = $this->_customerSession->create();

        if ($customerSession->isLoggedIn()) {
            $customerId = $customerSession->getCustomerId();
            $customer = $this->_customerRepositoryInterface->getById($customerId);

            // Check if the attribute exists and is set to 1 (yes), return the opposite
            $allowRequestSampleAttribute = $customer->getCustomAttribute('allow_request_sample');
            if ($allowRequestSampleAttribute !== null) {
                return !$allowRequestSampleAttribute->getValue();
            }
        }
        // If not logged in, consider the form disallowed
        return true;
    }
}
