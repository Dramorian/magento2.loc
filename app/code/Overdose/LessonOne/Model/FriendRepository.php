<?php

namespace Overdose\LessonOne\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Overdose\LessonOne\Api\FriendRepositoryInterface;

class FriendRepository implements FriendRepositoryInterface
{

    /**
     * @var null
     */
    private $model = null;

    /**
     * @var FriendsFactory
     */
    protected $friendsFactory;

    /**
     * @var Friends
     */
    protected $friendsResourceModel;

    /**
     * @var \Overdose\LessonOne\Model\ResourceModel\Collection\FriendsFactory
     */
    protected $friendsCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var \Magento\Framework\Api\Search\SearchResultInterfaceFactory
     */
    protected $searchResultFactory;

    /**
     * Friend Repository constructor
     *
     * @param \Overdose\LessonOne\Model\FriendsFactory $friendsFactory
     * @param \Overdose\LessonOne\Model\ResourceModel\Friends $friendsResourceModel
     * @param \Overdose\LessonOne\Model\ResourceModel\Collection\FriendsFactory $friendsCollectionFactory
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     * @param \Magento\Framework\Api\Search\SearchResultInterfaceFactory $searchResultFactory
     */
    public function __construct(
        \Overdose\LessonOne\Model\FriendsFactory                           $friendsFactory,
        \Overdose\LessonOne\Model\ResourceModel\Friends                    $friendsResourceModel,
        \Overdose\LessonOne\Model\ResourceModel\Collection\FriendsFactory  $friendsCollectionFactory,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor,
        \Magento\Framework\Api\Search\SearchResultInterfaceFactory         $searchResultFactory
    ) {
        $this->friendsFactory = $friendsFactory;
        $this->friendsResourceModel = $friendsResourceModel;
        $this->friendsCollectionFactory = $friendsCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * @inheritDoc
     */
    public function save($model)
    {
        try {
            return $this->friendsResourceModel->save($model);
        } catch (Exception $e) {
            throw new CouldNotSaveException(__("Sorry, I can't save your friend =("));
        }
    }

    /**
     * @inheritDoc
     */
    public function delete($model)
    {
        try {
            $this->friendsResourceModel->delete($model);

            return true;
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__("Sorry, I can't delete your friend =("));
        }
    }

    /**
     * @inheritDoc
     */
    public function deleteById($id)
    {
        try {
            $this->friendsResourceModel->delete($this->getById($id));

            return true;
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__("Sorry, I can't delete your friend =("));
        }
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        try {
            $model = $this->friendsFactory->create();
            $this->friendsResourceModel->load($model, $id);

            return $model;
        } catch (Exception $e) {
            throw new NoSuchEntityException(__("Sorry, I can't find your friend with such id =("));
        }
    }

    /**
     * @inheritDoc
     */
    public function getList($searchCriteria)
    {
        $collection = $this->friendsCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResult = $this->searchResultFactory->create();

        $searchResult->setSearchCriteria($searchCriteria)
            ->setTotalCount($collection->getSize())
            ->setItems($collection->getItems());

        return $searchResult;
    }

    /**
     * @return Friends
     */
    public function getEmptyModel()
    {
        return $this->friendsFactory->create();

    }
}
