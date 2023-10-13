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
    protected $_template = "widget/custom-widget.phtml";

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

    /**
     * @return string
     */
    public function getCmsBlockId()
    {
        return 'banner-homepage'; // Replace with your actual CMS Block identifier
    }

    public function getButtonUrl()
    {
        // Specify the CMS Page URL here
        return $this->getUrl('alex-cms');
    }
}
