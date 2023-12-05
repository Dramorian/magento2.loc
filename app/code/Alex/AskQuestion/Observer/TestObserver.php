<?php

namespace Alex\AskQuestion\Observer;

use Alex\AskQuestion\Model\ResourceModel\AskQuestion\Collection;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class TestObserver implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return Collection
     */
    public function execute(Observer $observer)
    {
        /** @var Collection $collection */
        $collection = $observer->getEvent()->getCollection();
        return $collection;
    }
}
