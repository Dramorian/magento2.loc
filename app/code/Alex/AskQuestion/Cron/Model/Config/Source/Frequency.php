<?php

namespace Alex\AskQuestion\Cron\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Frequency implements OptionSourceInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Every Day')],
            ['value' => 3, 'label' => __('Every 3 Days')],
            ['value' => 7, 'label' => __('Every 7 Days')],
            ['value' => 14, 'label' => __('Every 14 Days')],
            // Add more options as needed
        ];
    }
}
