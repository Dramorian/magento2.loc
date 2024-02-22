<?php

namespace Overdose\LessonOne\Api;

use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Overdose\LessonOne\Api\Data\FriendSearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Overdose\LessonOne\Api\Data\FriendInterface;
use Overdose\LessonOne\Model\Friends;

interface FriendRepositoryInterface
{

    /**
     * @param FriendInterface|Friends $model
     * @return FriendInterface|Friends
     * @throws LocalizedException
     */
    public function save($model);

    /**
     * Delete friend
     *
     * @param FriendInterface|Friends $model
     * @return bool true on success
     * @throws CouldNotDeleteException
     * @throws LocalizedException
     */
    public function delete(FriendInterface|Friends $model);

    /**
     * Get friend by ID
     *
     * @param int $id
     * @return FriendInterface|Friends
     * @throws LocalizedException
     */
    public function getById($id);

    /**
     * Delete friend by ID
     *
     * @param int $id
     * @return bool true on success
     * @throws CouldNotDeleteException
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function deleteById($id);


    /**
     * Get friends matching the specified criteria
     *
     * @param SearchCriteria $searchCriteria
     * @return FriendSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
