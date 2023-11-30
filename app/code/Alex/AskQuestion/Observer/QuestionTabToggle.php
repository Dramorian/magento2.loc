<?php

namespace Alex\AskQuestion\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Layout;

class QuestionTabToggle implements ObserverInterface
{
    /**
     * @var Registry
     */
    protected Registry $_registry;

    /**
     * @param Registry $registry
     */
    public function __construct(
        Registry $registry,
    ) {
        $this->_registry = $registry;
    }

    /**
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        $product = $this->_registry->registry('current_product');
        // remove tab if attribute set to "No"
        if ($product && !$product->getData('allow_to_ask_questions')) {
            /** @var Layout $layout */
            $layout = $observer->getLayout();
            $layout->getUpdate()->addHandle('catalog_product_view_formtoggle');
        }

        return $this;
    }
}
