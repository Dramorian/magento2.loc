<?php

namespace Alex\Lesson10\Ui\Component\Form\DataProvider\Modifier;

use Magento\Ui\Component\Form;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class CustomField implements ModifierInterface
{
    // modifyData (array $data) doesn't work
    // gives "must be of the type array, null given" error
    // presumably, current implementation just suppresses the error but doesn't solve the issue
    /**
     * @param $data
     * @return array
     */
    public function modifyData($data)
    {
        return is_array($data) ? $data : [];
    }

    /**
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta): array
    {
        $meta['general']['children']['custom_field'] = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Form\Field::NAME,
                        'formElement' => Form\Element\Input::NAME,
                        'label' => __('Custom Field from modifier'),
                        'dataType' => Form\Element\DataType\Text::NAME,
                        'sortOrder' => 45,
                        'dataScope' => 'custom_field',
                    ]
                ]
            ],
        ];

        return $meta;
    }
}
