<?php

namespace Alex\AskQuestion\Api;

use Alex\AskQuestion\Api\Data\AskQuestionInterface;
use Alex\AskQuestion\Api\Data\AskQuestionSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Ask Question CRUD interface.
 * @api
 */
interface AskQuestionRepositoryInterface
{
    /**
     * Save question
     *
     * @param AskQuestionInterface $askQuestion
     * @return AskQuestionInterface
     * @throws LocalizedException
     */
    public function save(AskQuestionInterface $askQuestion);

    /**
     * Retrieve question
     *
     * @param int $askQuestionId
     * @return AskQuestionInterface
     * @throws LocalizedException
     */
    public function getById($askQuestionId);

    /**
     * Retrieve questions matching the specified criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return AskQuestionSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete question
     *
     * @param AskQuestionInterface $askQuestion
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(AskQuestionInterface $askQuestion);

    /**
     * Delete question by ID
     *
     * @param int $askQuestionId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($askQuestionId);
}
