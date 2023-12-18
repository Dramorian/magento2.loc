<?php

namespace Alex\AskQuestion\Cron;

use Alex\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class UpdateQuestionStatus
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
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
        $collection->addFieldToFilter(
            'created_at',
            ['lteq' => date(
                'Y-m-d H:i:s',
                strtotime('-' . $this->getNumberOfDays() . ' days')
            )
            ]
        );

        foreach ($collection as $item) {
            $item->setStatus('Answered');
            $item->save();
        }
    }

    /**
     * @return int
     */
    protected function getNumberofDays()
    {
        return 3;
    }
}
