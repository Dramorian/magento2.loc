<?php

namespace Alex\AskQuestion\Plugin;

use Alex\AskQuestion\Model\ResourceModel\AskQuestion\Collection as QuestionCollection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class CollectionPlugin
{
    /**
     * @param QuestionCollection $collection
     * @return QuestionCollection
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function beforeLoad(QuestionCollection $collection): QuestionCollection
    {
        $collection->addStoreFilter();
        return $collection;
    }
}
