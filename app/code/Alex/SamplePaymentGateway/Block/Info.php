<?php

namespace Alex\SamplePaymentGateway\Block;

use Alex\SamplePaymentGateway\Gateway\Response\FraudHandler;
use Magento\Framework\Phrase;
use Magento\Payment\Block\ConfigurableInfo;

class Info extends ConfigurableInfo
{
    /**
     * Returns label
     *
     * @param string $field
     * @return Phrase
     */
    protected function getLabel($field)
    {
        return __($field);
    }

    /**
     * Returns value view
     *
     * @param string $field
     * @param string|array|null $value
     * @return string | Phrase
     */
    protected function getValueView($field, $value)
    {
        return match ($field) {
            FraudHandler::FRAUD_MSG_LIST => is_array($value) ? implode('; ', $value) : $value,
            default => parent::getValueView($field, $value),
        };
    }
}
