<?php

namespace Alex\AskQuestion\Model\ResourceModel\AskQuestion;

use Alex\AskQuestion\Model\AskQuestion;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'alex_ask_question_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'question_collection';

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    protected function _construct()
    {
        $this->_init(
            AskQuestion::class,
            \Alex\AskQuestion\Model\ResourceModel\AskQuestion::class
        );
    }

    /**
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param StoreManagerInterface $storeManager
     * @param AdapterInterface|null $connection
     * @param AbstractDb|null $resource
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface        $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface       $eventManager,
        StoreManagerInterface  $storeManager,
        AdapterInterface       $connection = null,
        AbstractDb             $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->storeManager = $storeManager;
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
