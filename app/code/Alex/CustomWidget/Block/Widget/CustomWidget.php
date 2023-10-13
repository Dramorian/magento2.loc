<?php

namespace Alex\CustomWidget\Block\Widget;

use Magento\Framework\Phrase;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class CustomWidget extends Template implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = "Alex_CustomWidget::widget/custom-widget.phtml";

    /**
     * @param $code
     * @return false|Phrase
     */
    public function getButtonTitle($code)
    {
        $result = false;
        switch ($code) {
            case 'title1':
                $result = __("Title 1");
                break;
            case 'title2':
                $result = __("Title 2");
                break;
            case 'title3':
                $result = __("Title 3");
                break;
        }

        return $result;
    }
}
