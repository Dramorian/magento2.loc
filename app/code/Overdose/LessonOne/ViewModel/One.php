<?php

namespace Overdose\LessonOne\ViewModel;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Overdose\LessonOne\Api\FriendRepositoryInterface;

class One implements ArgumentInterface
{
    /**
     * @var null
     */
    private $model;

    /**
     * @var FriendRepositoryInterface
     */
    protected $friendsRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @param FriendRepositoryInterface $friendsRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        FriendRepositoryInterface $friendsRepository,
        SearchCriteriaBuilder     $searchCriteriaBuilder
    ) {
        $this->friendsRepository = $friendsRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return string
     */
    public function iAmViewModel(): string
    {
        return 'Text from view model';
    }

    /**
     * @param int $friendCount
     * @return void
     * @throws AlreadyExistsException
     */
    public function saveNewFriend(int $friendCount): void
    {
        for ($i = 0; $i < $friendCount; $i++) {

            $model = $this->friendsRepository->getEmptyModel();

            $name = $this->generateRandomName();
            $age = random_int(18, 27);
            $comment = $this->generateRandomComment();

            $model->setData("name", $name)
                ->setData('age', $age)
                ->setData('comment', $comment);

            $this->friendsRepository->save($model);
        }
    }

    /**
     * Get all friends from database
     *
     * @return SearchResultsInterface
     */
    public function getAllFriends()
    {
        // Create a search criteria without any filters to retrieve all friends
        $searchCriteria = $this->searchCriteriaBuilder->create();

        // Get the list of friends using getList method
        return $this->friendsRepository->getList($searchCriteria);
    }

    /**
     * Get the name of a friend by ID
     *
     * @param int $id
     * @return string|null
     */
    public function getFriendName(int $id): ?string
    {
        // Return the friend's name
        return $this->getFriendModel($id)?->getData('name');
    }

    /**
     * Get the age of a friend by ID
     *
     * @param int $id
     * @return int|null
     */
    public function getFriendAge(int $id): ?int
    {
        // Return the friend's age
        return $this->getFriendModel($id)?->getData('age');
    }

    /**
     * @param $id
     * @return \Overdose\LessonOne\Model\Friends|null
     */
    public function getFriendModel($id)
    {
        if ($this->model === null || $this->model->getId() !== $id) {
            $model = $this->friendsRepository->getById($id);
            $this->model = $model;
        }

        return $this->model;
    }

    /**
     * Generate a random name
     *
     * @return string
     */
    protected function generateRandomName()
    {
        $names = ['John', 'Jane', 'Alice', 'Bob', 'Emma', 'Michael', 'Olivia', 'William', 'Sophia', 'James'];
        return $names[array_rand($names)];
    }

    /**
     * Generate a random comment
     *
     * @return string
     */
    protected function generateRandomComment()
    {
        $comments = ['Great friend!', 'Awesome person.', 'Always fun to be around.', 'Very kind and helpful.'];
        return $comments[array_rand($comments)];
    }
}
