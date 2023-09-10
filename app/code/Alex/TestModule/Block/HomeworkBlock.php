<?php

namespace Alex\TestModule\Block;

use Magento\Framework\View\Element\Template;

class HomeworkBlock extends Template
{

    const ALEX_TEMPLATE = "Alex_TestModule::homework/myhomework.phtml";

    /**
     * @return $this|HomeworkBlock
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->setTemplate(self::ALEX_TEMPLATE);

        return $this;


    }

    /**
     * @return string
     */
    public function getJsonControllerUrl()
    {
        return $this->getUrl('home-work/homework/jsonresponse');
    }
}
