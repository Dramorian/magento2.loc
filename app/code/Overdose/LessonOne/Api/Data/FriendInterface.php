<?php

namespace Overdose\LessonOne\Api\Data;

interface FriendInterface
{
    public const TABLE_NAME = 'overdose_lesson_one';

    public const FIELD_NAME_ID = 'id';
    public const FIELD_NAME_AGE = 'age';
    public const FIELD_NAME_NAME = 'name';
    public const FIELD_NAME_COMMENT = 'comment';
    public const FIELD_NAME_CREATED_AT = 'created_at';
    public const FIELD_NAME_UPDATED_AT = 'updated_at';


    /**
     * @return int
     */
    public function getId();

    /**
     * @return string|int
     */
    public function getAge();

    /**
     * @param string|int $age
     * @return FriendInterface
     */
    public function setAge($age);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return FriendInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getComment();

    /**
     * @param string $comment
     * @return FriendInterface
     */
    public function setComment($comment);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @return string
     */
    public function getUpdatedAt();

}
