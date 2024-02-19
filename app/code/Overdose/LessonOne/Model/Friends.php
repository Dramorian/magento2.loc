<?php

namespace Overdose\LessonOne\Model;

use Magento\Framework\Model\AbstractModel;
use Overdose\LessonOne\Api\Data\FriendInterface;

class Friends extends AbstractModel implements FriendInterface
{
    protected $_eventPrefix = 'friend_model_event_stuff';

    protected $_eventObject = 'friend_event_object';

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getData(self::FIELD_NAME_ID);
    }

    /**
     * @inheritDoc
     */
    public function getAge()
    {
        return $this->getData(self::FIELD_NAME_AGE);
    }

    /**
     * @inheritDoc
     */
    public function setAge($age)
    {
        return $this->setData($age, self::FIELD_NAME_AGE);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(self::FIELD_NAME_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        return $this->setData($name, self::FIELD_NAME_NAME);
    }

    /**
     * @inheritDoc
     */
    public function getComment()
    {
        return $this->getData(self::FIELD_NAME_COMMENT);
    }

    /**
     * @inheritDoc
     */
    public function setComment($comment)
    {
        return $this->setData($comment, self::FIELD_NAME_COMMENT);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt()
    {
        return $this->getData(self::FIELD_NAME_CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::FIELD_NAME_UPDATED_AT);
    }

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Friends::class);
    }
}
