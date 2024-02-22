<?php

namespace Overdose\LessonOne\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for friend search results.
 * @api
 */
interface FriendSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get friend list
     *
     * @return FriendInterface[]
     */
    public function getItems();

    /**
     * Set friend list
     *
     * @param FriendInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
