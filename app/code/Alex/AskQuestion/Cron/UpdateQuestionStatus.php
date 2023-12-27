<?php

namespace Alex\AskQuestion\Cron;

use Alex\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;

class UpdateQuestionStatus
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Execute the cron job
     *
     * @return void
     * @throws LocalizedException
     */
    public function execute()
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('status', 'Pending');

        foreach ($collection as $item) {
            $item->setStatus('Answered');
            $item->save();
        }
    }

    /**
     * @return int
     */
    protected function getNumberofDays(): int
    {
        return 3;
    }
}
