<?php

namespace Overdose\AdminPanel\Ui\Friend;

use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Overdose\LessonOne\Model\ResourceModel\Collection\FriendsFactory;
use Overdose\LessonOne\Model\ResourceModel\Collection\Friends;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var Friends
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    private array $loadedData = [];

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $blockCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        FriendsFactory $friendCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $friendCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Overdose\LessonOne\Model\Friends $friends */
        foreach ($items as $friends) {
            $this->loadedData[$friends->getId()] = $friends->getData();
        }

        $data = $this->dataPersistor->get('overdose_friend');
        if (!empty($data)) {
            $friends= $this->collection->getNewEmptyItem();
            $friends->setData($data);
            $this->loadedData[$friends->getId()] = $friends->getData();
            $this->dataPersistor->clear('cms_block');
        }

        return $this->loadedData;
    }
}
