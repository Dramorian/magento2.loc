<?php

namespace Alex\AskQuestion\Observer;

use Magento\Catalog\Model\Product;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class QuestionTabToggle implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var Product $product */
        $product = $observer->getProduct();

        // Check if the product has the "allow_to_ask_questions" attribute set to "No"
        if ($product->getAttribute('allow_to_ask_questions') === 0) {
            // Remove the "Ask a Question" tab from the layout
            $layout = $observer->getData('layout');
            $layout->getUpdate()->addHandle('catalog_product_view_formhandle');
        }
    }
}
