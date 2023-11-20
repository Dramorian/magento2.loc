<?php

namespace Alex\AskQuestion\Ui\Source\Listing\Column;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'label' => __('Pending'),
                'value' => 'pending',
            ],
            [
                'label' => __('Answered'),
                'value' => 'answered',
            ],
            // Add more status options as needed
        ];
    }
}
