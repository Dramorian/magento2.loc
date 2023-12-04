<?php

namespace Alex\AskQuestion\Model\ResourceModel\AskQuestion\Grid;

use Alex\AskQuestion\Model\ResourceModel\AskQuestion\Collection as QuestionCollection;
use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class Collection extends QuestionCollection implements SearchResultInterface
{
    /**
     * @var TimezoneInterface
     */
    private TimezoneInterface $timeZone;

    /**
     * @var AggregationInterface
     */
    protected AggregationInterface $aggregations;


    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface    $entityFactory,
        \Psr\Log\LoggerInterface                                     $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        ManagerInterface                                             $eventManager,
        \Magento\Framework\DB\Adapter\AdapterInterface               $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb         $resource = null,
                                                                     $mainTable,
                                                                     $eventPrefix,
                                                                     $eventObject,
                                                                     $resourceModel
    )
    {
        $this->setMainTable($mainTable);

        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

//    /**
//     * @param EntityFactoryInterface $entityFactory
//     * @param LoggerInterface $logger
//     * @param FetchStrategyInterface $fetchStrategy
//     * @param ManagerInterface $eventManager
//     * @param $mainTable
//     * @param $eventPrefix
//     * @param $eventObject
//     * @param $resourceModel
//     * @param TimezoneInterface $timeZone
//     * @param string $model
//     * @param AdapterInterface|null $connection
//     * @param AbstractDb|null $resource
//     */
//    public function __construct(
//        EntityFactoryInterface $entityFactory,
//        LoggerInterface        $logger,
//        FetchStrategyInterface $fetchStrategy,
//        ManagerInterface       $eventManager,
//        StoreManagerInterface  $storeManager,
//                               $mainTable,
//                               $eventPrefix,
//                               $eventObject,
//                               $resourceModel,
//        TimezoneInterface      $timeZone,
//                               $model = Document::class,
//        AdapterInterface       $connection = null,
//        AbstractDb             $resource = null,
//
//    )
//    {
//        $this->_eventPrefix = $eventPrefix;
//        $this->_eventObject = $eventObject;
//        $this->timeZone = $timeZone;
//        $this->storeManager = $storeManager;
//        $this->_init($model, $resourceModel);
//
//
//        $this->setMainTable($mainTable);
//        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
//    }


    /**
     * @param $field
     * @param $condition
     * @return Collection
     * @throws LocalizedException
     */
    public function addFieldToFilter($field, $condition = null)
    {
        if (($field === 'created_at') && is_array($condition)) {
            foreach ($condition as $key => $value) {
                $condition[$key] = $this->timeZone->convertConfigTimeToUtc($value);
            }
        }

        return parent::addFieldToFilter($field, $condition);
    }

    /**
     * Get aggregation interface instance
     *
     * @return AggregationInterface
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * Set aggregation interface instance
     *
     * @param AggregationInterface $aggregations
     * @return $this
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
        return $this;
    }

    /**
     * Get search criteria.
     *
     * @return SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * Set search criteria.
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * Set total count.
     *
     * @param int $totalCount
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * Set items list.
     *
     * @param ExtensibleDataInterface[] $items
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setItems(array $items = null)
    {
        return $this;
    }


}
