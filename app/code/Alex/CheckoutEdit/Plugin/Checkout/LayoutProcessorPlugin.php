<?php

namespace Alex\CheckoutEdit\Plugin\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessor;

class LayoutProcessorPlugin
{
    /**
     * @param LayoutProcessor $subject
     * @param $jsLayout
     * @return array
     */
    public function afterProcess(LayoutProcessor $subject, $jsLayout)
    {
        $customAttributeCode = 'new_field';

        // Adding new field to the shipping address form
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['new_field'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'options' => [],
                'tooltip' => [
                    'description' => 'New field created by LayoutProcessor plugin',
                ],
            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . $customAttributeCode,
            'label' => 'New Field',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => ['required-entry' => false],
            'sortOrder' => 250,
            'id' => 'new_field',
        ];

        return $jsLayout;
    }
}
