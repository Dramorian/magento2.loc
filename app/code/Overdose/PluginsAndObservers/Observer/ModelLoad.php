<?php

namespace Overdose\PluginsAndObservers\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ModelLoad implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        $x = 1;

        $friendsModel = $observer->getData('friend_event_object');


        return $this;
    }
}
