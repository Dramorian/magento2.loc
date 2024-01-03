<?php

namespace Alex\RequestSample\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for request sample search results.
 * @api
 */
interface RequestSampleSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get request samples list.
     *
     * @return RequestSampleInterface[]
     */
    public function getItems();

    /**
     * Set request samples list.
     *
     * @param RequestSampleInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
