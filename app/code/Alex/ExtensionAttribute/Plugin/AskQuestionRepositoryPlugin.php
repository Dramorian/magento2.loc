<?php

namespace Alex\ExtensionAttribute\Plugin;

use Alex\AskQuestion\Api\AskQuestionRepositoryInterface;
use Alex\AskQuestion\Api\Data\AskQuestionInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class AskQuestionRepositoryPlugin
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        StoreManagerInterface $storeManager,
    ) {
        $this->storeManager = $storeManager;
    }

    /**
     * Set website id as an extension attribute after getById method.
     *
     * @param AskQuestionRepositoryInterface $subject
     * @param AskQuestionInterface $result
     * @return AskQuestionInterface
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function afterGetById(AskQuestionRepositoryInterface $subject, AskQuestionInterface $result)
    {
        // Get store ID from the item (assuming it's available)
        $storeId = $result->getStoreId();

        // Check if store ID is retrieved successfully
        if ($storeId) {
            // Get website ID based on the store ID
            $websiteId = $this->storeManager->getWebsite($storeId)->getId();
            $result->getExtensionAttributes()->setWebsiteId($websiteId);
        }

        return $result;
    }
}
