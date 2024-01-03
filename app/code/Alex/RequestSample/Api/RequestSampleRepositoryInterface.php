<?php

namespace Alex\RequestSample\Api;

use Alex\RequestSample\Api\Data\RequestSampleInterface;
use Alex\RequestSample\Api\Data\RequestSampleSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Request Sample CRUD interface.
 * @api
 */
interface RequestSampleRepositoryInterface
{
    /**
     * Save request sample.
     *
     * @param RequestSampleInterface $requestSample
     * @return RequestSampleInterface
     * @throws LocalizedException
     */
    public function save(RequestSampleInterface $requestSample);

    /**
     * Retrieve request sample.
     *
     * @param int $requestSampleId
     * @return RequestSampleInterface
     * @throws LocalizedException
     */
    public function getById($requestSampleId);

    /**
     * Retrieve request samples matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return RequestSampleSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete request sample.
     *
     * @param RequestSampleInterface $requestSample
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(RequestSampleInterface $requestSample);

    /**
     * Delete request sample by ID.
     *
     * @param int $requestSampleId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($requestSampleId);
}
