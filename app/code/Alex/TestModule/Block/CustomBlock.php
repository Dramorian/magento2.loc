<?php

namespace Alex\TestModule\Block;


use Magento\Framework\View\Element\Template;

class CustomBlock extends Template
{
    const ALEX_TEMPLATE = "Alex_TestModule::test/testTemplate.phtml";

    /**
     * * add custom template
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->setTemplate(self::ALEX_TEMPLATE);

        return $this;

    }
}
