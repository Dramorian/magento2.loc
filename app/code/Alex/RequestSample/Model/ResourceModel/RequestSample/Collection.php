<?php

namespace Alex\RequestSample\Model\ResourceModel\RequestSample;

use Alex\RequestSample\Model\RequestSample;
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
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Collection constructor.
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
    )
    {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            RequestSample::class,
            \Alex\RequestSample\Model\ResourceModel\RequestSample::class
        );
    }

    /**
     * @param int $storeId
     * @return Collection
     * @throws NoSuchEntityException
     */
    public function addStoreFilter(int $storeId = 0): self
    {
        if (!$storeId) {
            $storeId = $this->storeManager->getStore()->getId();
        }

        $this->addFieldToFilter('store_id', $storeId);

        return $this;
    }
}
