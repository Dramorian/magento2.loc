<?php

namespace Alex\Homework10\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Element\Checkbox;
use Magento\Ui\Component\Form\Element\ColorPicker;

class NewField extends AbstractModifier
{
    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * @param LocatorInterface $locator
     */
    public function __construct(
        LocatorInterface $locator
    ) {
        $this->locator = $locator;
    }

    /**
     * @param array $data
     * @return array
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        // Add a text input field to the custom fieldset
        $meta = array_replace_recursive(
            $meta,
            [
                'custom_fieldset' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'label' => __('Custom Fieldset'),
                                'componentType' => Fieldset::NAME,
                                'dataScope' => 'data.product.custom_fieldset',
                                'collapsible' => true,
                                'sortOrder' => 5,
                            ],
                        ],
                    ],
                    'children' => [
                        'custom_field' => $this->getCustomField(), // Example Select field
                        'custom_text_field' => $this->getCustomTextField(), // New Text input field
                        'custom_checkbox' => $this->getCustomCheckbox(), // New Checkbox field
                        'custom_color_picker' => $this->getCustomColorPicker() // New ColorPicker field
                    ],
                ]
            ]
        );

        return $meta;
    }

    /**
     * @return array[]
     */
    public function getCustomField()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Custom Field'),
                        'componentType' => Field::NAME,
                        'formElement' => Select::NAME,
                        'dataScope' => 'enabled',
                        'dataType' => Text::NAME,
                        'sortOrder' => 10,
                        'options' => [
                            ['value' => '0', 'label' => __('No')],
                            ['value' => '1', 'label' => __('Yes')]
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Add a new text input field
     *
     * @return array[]
     */
    public function getCustomTextField()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Custom Text Field'),
                        'componentType' => Field::NAME,
                        'formElement' => 'input',
                        'dataScope' => 'custom_text',
                        'dataType' => Text::NAME,
                        'sortOrder' => 20,
                    ],
                ],
            ],
        ];
    }

    /**
     * Add a new checkbox field
     *
     * @return array[]
     */
    public function getCustomCheckbox()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Custom Checkbox'),
                        'componentType' => Field::NAME,
                        'formElement' => Checkbox::NAME,
                        'dataScope' => 'custom_checkbox',
                        'dataType' => Text::NAME,
                        'sortOrder' => 30,
                        'valueMap' => [
                            'true' => '1',
                            'false' => '0'
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Add a new ColorPicker field
     *
     * @return array[]
     */
    public function getCustomColorPicker()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Custom Color Picker'),
                        'componentType' => Field::NAME,
                        'formElement' => ColorPicker::NAME,
                        'dataScope' => 'custom_colorpicker',
                        'dataType' => Text::NAME,
                        'sortOrder' => 40,
                    ],
                ],
            ],
        ];
    }
}
