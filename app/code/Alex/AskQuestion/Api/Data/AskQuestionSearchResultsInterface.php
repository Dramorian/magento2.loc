<?php

namespace Alex\AskQuestion\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for question search results.
 * @api
 */
interface AskQuestionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get questions list.
     *
     * @return AskQuestionInterface[]
     */
    public function getItems();

    /**
     * Set question list.
     *
     * @param AskQuestionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
