<?php

namespace Alex\RequestSample\Observer\Catalog\Controller\Product\View;

use Magento\Catalog\Controller\Product\View;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Predispatch implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var View $controllerAction */
        $controllerAction = $observer->getEvent()->getData('controller_action');
        /** @var Http $request */
        $request = $observer->getEvent()->getData('request');
    }
}
