<?php

namespace Overdose\AdminPanel\Block\Adminhtml\Friend\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'overdose_friends_form.overdose_friends_form',
                                'actionName' => 'save',
                                'params' => [
                                    true,
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }
}
