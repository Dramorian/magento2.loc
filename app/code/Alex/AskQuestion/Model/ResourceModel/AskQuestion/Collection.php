<?php

namespace Alex\AskQuestion\Model\ResourceModel\AskQuestion;

use Alex\AskQuestion\Model\AskQuestion;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Store\Model\StoreManagerInterface;

class Collection extends AbstractCollection
{

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    protected function _construct()
    {
        $this->_init(
            AskQuestion::class,
            \Alex\AskQuestion\Model\ResourceModel\AskQuestion::class
        );
    }

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface    $entityFactory,
        \Psr\Log\LoggerInterface                                     $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        ManagerInterface                                             $eventManager,
        StoreManagerInterface                                        $storeManager,
        \Magento\Framework\DB\Adapter\AdapterInterface               $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb         $resource = null
    ) {
        $this->storeManager = $storeManager;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    /**
     * @param int $storeId
     * @return $this
     * @throws NoSuchEntityException
     */
    public function addStoreFilter(int $storeId = 0)
    {
        if (!$storeId) {
            $storeId = $this->storeManager->getStore()->getId();
        }

        $this->addFieldToFilter('store_id', $storeId);

        return $this;
    }
}
