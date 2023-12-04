<?php

namespace Alex\AskQuestion\Plugin;

use Alex\AskQuestion\Model\ResourceModel\AskQuestion\Collection as QuestionCollection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class CollectionPlugin
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * CollectionPlugin constructor.
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
    }

    /**
     * @param QuestionCollection $collection
     * @return QuestionCollection
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function beforeLoad(QuestionCollection $collection)
    {
        $storeId = 1;
        $collection->addStoreFilter($storeId);
        return $collection;
    }
}
