<?php

namespace Overdose\LessonOne\Api;

use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Overdose\LessonOne\Api\Data\FriendInterface;
use Overdose\LessonOne\Model\Friends;

interface FriendRepositoryInterface
{

    /**
     * @param FriendInterface|Friends $model
     * @return FriendInterface|Friends
     */
    public function save($model);

    /**
     * @param FriendInterface|Friends $model
     * @return true
     * @throws CouldNotDeleteException
     */
    public function delete($model);

    /**
     * @param int $id
     * @return FriendInterface|Friends
     */
    public function getById($id);

    /**
     * @param int $id
     * @return true
     * @throws CouldNotDeleteException
     */
    public function deleteById($id);


    /**
     * @param SearchCriteria $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList($searchCriteria);
}
