<?php


namespace Overdose\LessonOne\ViewModel;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class One implements ArgumentInterface
{
    /**
     * @var null
     */
    private $model = null;



    /**
     * @param \Overdose\LessonOne\Model\FriendsFactory $friendsFactory
     * @param \Overdose\LessonOne\Model\ResourceModel\Friends $friendsResourceModel
     * @param \Overdose\LessonOne\Model\ResourceModel\Collection\FriendsFactory $friendsCollectionFactory
     */
    public function __construct(
        \Overdose\LessonOne\Model\FriendsFactory                          $friendsFactory,
        \Overdose\LessonOne\Model\ResourceModel\Friends                   $friendsResourceModel,
        \Overdose\LessonOne\Model\ResourceModel\Collection\FriendsFactory $friendsCollectionFactory
    ) {
        $this->friendsFactory = $friendsFactory;
        $this->friendsResourceModel = $friendsResourceModel;
        $this->friendsCollectionFactory = $friendsCollectionFactory;
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
            $model = $this->friendsFactory->create();

            $name = $this->generateRandomName();
            $age = random_int(18, 27);
            $comment = $this->generateRandomComment();

            $model->setData("name", $name)
                ->setData('age', $age)
                ->setData('comment', $comment);

            $this->friendsResourceModel->save($model);
        }
    }

    /**
     * @return mixed
     */
    public function getAllFriends(): mixed
    {
        $collection = $this->friendsCollectionFactory->create();

        // Sort the collection by created_at in descending order
        $collection->addOrder('created_at', 'DESC');

        // Limit the collection to the 10 latest items
        $collection->setPageSize(20);

        return $collection->getItems();
    }

    /**
     * @param $id
     * @return string|null
     */
    public function getFriendName($id): ?string
    {
        if ($this->model === null) {
            $model = $this->friendsFactory->create();

            $this->friendsResourceModel->load($model, $id);

            $this->model = $model;
        }
        // Return the friend's name
        return $this->model->getData('name');
    }

    /**
     * @param $id
     * @return int|null
     */
    public function getFriendAge($id): ?int
    {
        // Return the friend's age
        return $this->getFriendModel($id)->getData('age');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getFriendModel($id): mixed
    {
        if ($this->model === null) {
            $model = $this->friendsFactory->create();

            $this->friendsResourceModel->load($model, $id);

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
