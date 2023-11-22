<?php

namespace Alex\AskQuestion\Ui\Source\Listing\Column;


use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    public const STATUS_PENDING = 'Pending';
    public const STATUS_ANSWERED = 'Answered';

    /**
     * @return array[]
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::STATUS_PENDING,
                'label' => __('Pending'),

            ],
            [
                'value' => self::STATUS_ANSWERED,
                'label' => __('Answered'),

            ],
            // Add more status options as needed
        ];
    }
}
