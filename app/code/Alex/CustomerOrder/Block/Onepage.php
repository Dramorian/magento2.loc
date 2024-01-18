<?php
namespace Alex\CustomerOrder\Block;

use Magento\Framework\View\Element\Template;

class Onepage extends Template
{
    public function getJsLayout()
    {
        $this->jsLayout['components']['onepageScope']['children']['steps']['children']['customer-step']['config']['customersListUrl'] = $this->getUrl('alex/customer/getList');

        return json_encode($this->jsLayout, JSON_HEX_TAG);
    }
}
