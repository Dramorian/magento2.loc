<?php

namespace Alex\CheckoutEdit\Block;

use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class NewField extends Template
{
    /**
     * @var ShippingInformationInterface
     */
    private $_addressInformation;

    /**
     * @param Context $context
     * @param ShippingInformationInterface $addressInformation
     * @param array $data
     */
    public function __construct(
        Context                      $context,
        ShippingInformationInterface $addressInformation,
        array                        $data = []
    ) {
        $this->_addressInformation = $addressInformation;
        parent::__construct($context, $data);
    }

    /**
     * Get custom Shipping Charge
     *
     * @return String
     */
    public function getShippingCharge()
    {
        return $this->_addressInformation->getExtensionAttributes()->getNewField(); //get custom attribute data.
    }
}
