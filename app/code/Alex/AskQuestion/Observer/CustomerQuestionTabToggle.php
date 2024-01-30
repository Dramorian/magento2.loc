<?php

namespace Alex\AskQuestion\Observer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Store\Model\ScopeInterface;

class CustomerQuestionTabToggle implements ObserverInterface
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
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @param Registry $registry
     * @param CustomerRepositoryInterface $customerRepositoryInterface
     * @param SessionFactory $customerSession
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Registry                    $registry,
        CustomerRepositoryInterface $customerRepositoryInterface,
        SessionFactory              $customerSession,
        ScopeConfigInterface        $scopeConfig
    ) {
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->registry = $registry;
        $this->_customerSession = $customerSession;
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * @param Observer $observer
     * @return $this
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        $product = $this->registry->registry('current_product');

        if (!$product) {
            return $this;
        }

        if ($this->isAskQuestionFormDisallowed()) {
            $layout = $observer->getLayout();
            $askQuestionBlock = $layout->getBlock('ask.question.tab');
            if ($askQuestionBlock) {
                $askQuestionBlock->setTemplate('');
            }
        }

        return $this;
    }

    /**
     * Check attribute value, disable the form if value is set to 1
     *
     * Check customer group, compare value from account settings to admin configuration
     *
     * @return bool
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    /**
     * Check attribute value, disable the form if value is set to 1
     *
     * Check customer group, compare value from account settings to admin configuration
     *
     * @return bool
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    private function isAskQuestionFormDisallowed(): bool
    {
        $customerSession = $this->_customerSession->create();

        if ($customerSession->isLoggedIn()) {
            $customerId = $customerSession->getCustomerId();
            $customer = $this->_customerRepositoryInterface->getById($customerId);

            $disallowAskQuestionAttribute = $customer->getCustomAttribute('disallow_ask_question');
            $forbiddenCustomerGroups = explode(
                ',',
                $this->_scopeConfig->getValue(
                    'askquestion_options/customer_groups/forbidden_customer_groups',
                    ScopeInterface::SCOPE_STORE
                )
            );

            // Check if either attribute is disallowed or customer is in forbidden group
            if (($disallowAskQuestionAttribute !== null && $disallowAskQuestionAttribute->getValue())
                || in_array($customer->getGroupId(), $forbiddenCustomerGroups)
            ) {
                return true; // Form is disallowed for this customer
            }
        }

        // If not logged in or not in the forbidden group, consider the form allowed
        return false;
    }
}
