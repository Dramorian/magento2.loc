<?php

namespace Overdose\Attributes\Model\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class MyAttributeSource extends AbstractSource
{

    /**
     * Retrieve All options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['label' => __('Cotton'), 'value' => 'cotton'],
                ['label' => __('Leather'), 'value' => 'leather'],
                ['label' => __('Silk'), 'value' => 'silk'],
                ['label' => __('Denim'), 'value' => 'denim'],
                ['label' => __('Fur'), 'value' => 'Fur'],
                ['label' => __('Wool'), 'value' => 'wool'],
                ['label' => __('Dragon scale'), 'value' => 'dragon_scale'],
                ['label' => __('Unicorn leather'), 'value' => 'unicorn_leather'],
            ];
        }
        return $this->_options;
    }
}
