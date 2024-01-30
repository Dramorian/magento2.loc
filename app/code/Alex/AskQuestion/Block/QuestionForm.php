<?php

namespace Alex\AskQuestion\Block;

use Magento\Catalog\Block\Product\View;

class QuestionForm extends View
{
    /**
     * @return int
     */
    public function getCurrentCustomerId(): int
    {
        $currentCustomer = $this->customerSession->getCustomer();

        return (int)$currentCustomer?->getId();
    }
}
