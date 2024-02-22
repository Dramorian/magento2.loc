<?php

namespace Overdose\LessonOne\Model;

use Exception;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Overdose\LessonOne\Api\Data\AskQuestionInterfaceFactory;
use Overdose\LessonOne\Api\Data\FriendInterface;
use Overdose\LessonOne\Api\Data\FriendSearchResultsInterfaceFactory;
use Overdose\LessonOne\Api\FriendRepositoryInterface;
use Overdose\LessonOne\Model\ResourceModel\Collection\Friends;
use Overdose\LessonOne\Model\ResourceModel\Collection\FriendsFactory;

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
     * @var FriendSearchResultsInterfaceFactory
     */
    protected $searchResultFactory;

    /**
     * @var FriendInterfaceFactory
     */
    protected $dataFriendFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * Friend Repository constructor
     *
     * @param FriendsFactory $friendsFactory
     * @param \Overdose\LessonOne\Model\ResourceModel\Friends $friendsResourceModel
     * @param FriendsFactory $friendsCollectionFactory
     * @param AskQuestionInterfaceFactory $dataFriendFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param FriendSearchResultsInterfaceFactory $searchResultFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     */
    public function __construct(
        \Overdose\LessonOne\Model\FriendsFactory                           $friendsFactory,
        \Overdose\LessonOne\Model\ResourceModel\Friends                    $friendsResourceModel,
        \Overdose\LessonOne\Model\ResourceModel\Collection\FriendsFactory  $friendsCollectionFactory,
        \Overdose\LessonOne\Api\Data\FriendInterfaceFactory           $dataFriendFactory,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor,
        \Overdose\LessonOne\Api\Data\FriendSearchResultsInterfaceFactory   $searchResultFactory,
        \Magento\Framework\Api\DataObjectHelper                            $dataObjectHelper,
        \Magento\Framework\Reflection\DataObjectProcessor                  $dataObjectProcessor
    ) {
        $this->friendsFactory = $friendsFactory;
        $this->friendsResourceModel = $friendsResourceModel;
        $this->friendsCollectionFactory = $friendsCollectionFactory;
        $this->dataFriendFactory = $dataFriendFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultFactory = $searchResultFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }

    /**
     * @inheritDoc
     * @throws CouldNotSaveException
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
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        try {
            $model = $this->friendsFactory->create();
            $this->friendsResourceModel->load($model, $id, FriendInterface::FIELD_NAME_ID);

            if (!empty($model->getData())) {
                return $model;
            }

        } catch (Exception $e) {
        }
        throw new NoSuchEntityException(__("There is no friends record with id of %1", $id));
    }


    /**
     * @param SearchCriteriaInterface $criteria
     * @return Friends
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->friendsCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() === SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $friends = [];
        /** @var \Overdose\LessonOne\Model\Friends $friendsModel */
        foreach ($collection as $friendsModel) {
            $friendsData = $this->dataFriendFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $friendsData,
                $friendsModel->getData(),
                FriendInterface::class
            );
            $friends[] = $this->dataObjectProcessor->buildOutputDataArray(
                $friendsData,
                FriendInterface::class
            );
        }
        $searchResults->setItems($friends);
        return $searchResults;
    }

    /**
     * @return Friends
     */
    public function getEmptyModel()
    {
        return $this->friendsFactory->create();
    }
}
