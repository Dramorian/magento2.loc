<?php

namespace Alex\AskQuestion\Block;

use Alex\AskQuestion\Model\ResourceModel\AskQuestion\Collection;
use Alex\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Questions extends Template
{
    public const CUSTOMERS_LIMIT = 10;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var Session
     */
    private $customerSession;

    /**
     * Questions constructor
     *
     * @param CollectionFactory $collectionFactory
     * @param Context $context
     * @param Session $customerSession
     * @param array $data
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Context           $context,
        Session           $customerSession,
        array             $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->customerSession = $customerSession;
    }

    /**
     * @return Collection
     */
    public function getQuestions(): Collection
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->getSelect()->orderRand();
        if ($limit = $this->getData('limit')) {
            $collection->setPageSize($limit);
        }
        return $collection;
    }

    /**
     * @param Customer $customer
     * @return Collection
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    private function getQuestionsByCustomer(Customer $customer): Collection
    {
        if (!$customer->getId()) {
            throw new LocalizedException(__('No customer has been found!'));
        }

        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->getSelect()->order('created_at DESC'); // Order by creation date in descending order

        $collection->addFieldToFilter('customer_id', ['eq' => $customer->getId()]);

        $limit = $this->getData('limit') ?: self::CUSTOMERS_LIMIT;
        $collection->setPageSize($limit);

        return $collection;
    }

    /**
     * @return Collection
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getMyQuestions(): Collection
    {
        $currentCustomer = $this->customerSession->getCustomer();

        return $this->getQuestionsByCustomer($currentCustomer);
    }

}
