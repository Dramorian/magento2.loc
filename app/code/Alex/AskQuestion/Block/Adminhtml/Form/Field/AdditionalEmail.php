<?php

namespace Alex\AskQuestion\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class AdditionalEmail
 */
class AdditionalEmail extends AbstractFieldArray
{
    /**
     * {@inheritdoc}
     */
    protected function _prepareToRender()
    {
        $this->addColumn('firstname', ['label' => __('First Name'), 'class' => 'required-entry']);
        $this->addColumn('lastname', ['label' => __('Last Name')]);
        $this->addColumn('email',['label' => __('Email'), 'size' => '50px', 'class' => 'required-entry validate-email']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Email');
    }
}
