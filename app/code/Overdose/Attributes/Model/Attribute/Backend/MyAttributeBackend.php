<?php

namespace Overdose\Attributes\Model\Attribute\Backend;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\Exception\LocalizedException;

class MyAttributeBackend extends AbstractBackend
{

    /**
     * Validate
     *
     * @param Product $object
     * @return bool
     * @throws LocalizedException
     */
    public function validate($object)
    {
        $value = $object->getData($this->getAttribute()->getAttributeCode());

        if ($value === 'dragon_scale' || $value === 'unicorn_leather') {
            throw new LocalizedException(
                __("Jesus Christ. Dragons do not exist. Unicorns either.")
            );
        }

        return true;
    }
}
