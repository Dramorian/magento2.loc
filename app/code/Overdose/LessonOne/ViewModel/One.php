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
     * @param $name
     * @param $age
     * @param $comment
     * @return void
     * @throws AlreadyExistsException
     */
    public function saveNewFriend($name, $age, $comment): void
    {
        for ($i = 0; $i < 10; $i++) {
            $model = $this->friendsFactory->create();

            $model->setData('name', $name)
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
}
