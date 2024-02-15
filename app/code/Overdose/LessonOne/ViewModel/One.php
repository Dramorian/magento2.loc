<?php


namespace Overdose\LessonOne\ViewModel;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Overdose\LessonOne\Api\Data\FriendInterface;
use Overdose\LessonOne\Api\FriendRepositoryInterface;
use Overdose\LessonOne\Model\FriendRepository;
use Overdose\LessonOne\Model\ResourceModel\Collection\Friends;

class One implements ArgumentInterface
{
    /**
     * @var null|\Overdose\LessonOne\Model\Friends
     */
    private $model = null;

    /**
     * @var Friends
     */
    protected $friendsResourceModel;

    /**
     * @var \Overdose\LessonOne\Model\ResourceModel\Collection\FriendsFactory
     */
    protected $friendsCollectionFactory;

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
     * @param string $name
     * @param int $age
     * @param string $comment
     * @return void
     * @throws CouldNotSaveException
     */
    /**
     * @param string $name
     * @param int $age
     * @param string $comment
     * @throws CouldNotSaveException
     */
    /**
     * Save a new friend entity with the provided data.
     *
     * @param string $name
     * @param int $age
     * @param string $comment
     */
    public function saveNewFriend(string $name, int $age, string $comment)
    {
        // Create a new instance of the friend entity
        $model = $this->friendsRepository->getEmptyModel();

        // Set the attributes of the friend entity
        $model->setName($name)
            ->setAge($age)
            ->setComment($comment);

        // Save the friend entity
        $this->friendsRepository->save($model);
    }


    /**
     * Get collection of all friends from 'overdose_lesson_one
     *
     * @return \Magento\Framework\Api\ExtensibleDataInterface[]
     */
    public function getAllFriends()
    {
    $searchCriteria = $this->searchCriteriaBuilder->create();

    // Retrieve the list of friends based on the search criteria
        // Return an array of friend objects
    return $this->friendsRepository->getList($searchCriteria)->getItems();

//        $collection = $this->friendsCollectionFactory->create();
//
//        // Sort the collection by created_at in descending order
//        $collection->addOrder('created_at', 'DESC');
//
//        // Limit the collection to the desired number of latest items
//        $collection->setPageSize(20);
//
//        return $collection->getItems();
    }

    /**
     * @param int $id
     * @return string|null
     */
    public function getFriendName(int $id): ?string
    {
        try {
            // Return the friend's name
            return $this->friendsRepository->getById($id)->getName();
        } catch (NoSuchEntityException $e) {
            // Handle the case where the friend with the given ID does not exist
            return null;
        }
    }

    /**
     * @param int $id
     * @return int|null
     */
    public function getFriendAge(int $id): ?int
    {
        try {
            // Return the friend's age
            return $this->friendsRepository->getById($id)->getAge();
        } catch (NoSuchEntityException $e) {
            // Handle the case where the friend with the given ID does not exist
            return null;
        }
    }
}
