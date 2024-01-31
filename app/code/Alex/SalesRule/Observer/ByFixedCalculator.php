<?php

namespace Alex\SalesRule\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Quote\Model\Quote\Item;
use Magento\SalesRule\Model\Rule;
use Magento\SalesRule\Model\Rule\Action\Discount\Data as DiscountData;
use Magento\SalesRule\Model\Validator;

class ByFixedCalculator implements ObserverInterface
{
    /**
     * @var PriceCurrencyInterface $priceCurrency
     */
    private $priceCurrency;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * ByFixedCalculator constructor.
     * @param PriceCurrencyInterface $priceCurrency
     * @param Validator $validator
     */
    public function __construct(
        PriceCurrencyInterface $priceCurrency,
        Validator              $validator
    ) {
        $this->priceCurrency = $priceCurrency;
        $this->validator = $validator;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var Rule $rule */
        $rule = $observer->getEvent()->getData('rule');

        if (
            $rule->getSimpleAction() !== Rule::BY_FIXED_ACTION
            || $rule->getApplyActionOn() === 'apply_on_minimal_price'
        ) {
            return;
        }

        /** @var DiscountData $discountData */
        $discountData = $observer->getEvent()->getData('result');
        /** @var Item $item */
        $item = $observer->getEvent()->getData('item');
        $qty = $observer->getEvent()->getData('qty');

        $discountAmount = (float)$rule->getDiscountAmount(); // this is amount in the base currency
        $baseItemPrice = $this->validator->getItemBasePrice($item);
        $baseItemOriginalPrice = $this->validator->getItemBaseOriginalPrice($item);
        $discountAmount -= $baseItemOriginalPrice - $baseItemPrice;

        if ($discountAmount <= 0) {
            $discountData->setAmount(0);
            $discountData->setBaseAmount(0);
        } else {
            $quoteAmount = $this->priceCurrency->convert($discountAmount, $item->getQuote()->getStore());
            $discountData->setAmount($qty * $quoteAmount);
            $discountData->setBaseAmount($qty * $discountAmount);
        }
    }
}
