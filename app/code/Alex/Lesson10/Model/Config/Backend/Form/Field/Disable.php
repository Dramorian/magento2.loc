<?php

namespace Alex\Lesson10\Model\Config\Backend\Form\Field;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class Disable
 * @package Alex\Lesson10\Model\Config\Backend\Form\Field
 */
class Disable extends Field
{
    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $element->setData('readonly', 1);
        return $element->getElementHtml();

    }
}
