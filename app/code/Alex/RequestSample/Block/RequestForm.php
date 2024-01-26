<?php

namespace Alex\RequestSample\Block;

use Magento\Catalog\Block\Product\View;

class RequestForm extends View
{
    /**
     * @return int
     */
    public function getCurrentCustomerId(): int
    {
        $currentCustomer = $this->customerSession->getCustomer();

        return $currentCustomer ? (int)$currentCustomer->getId() : 0;
    }
}
