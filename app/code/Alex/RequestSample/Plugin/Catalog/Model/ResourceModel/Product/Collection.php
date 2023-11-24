<?php

namespace Alex\RequestSample\Plugin\Catalog\Model\ResourceModel\Product;

use Closure;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;

class Collection
{
    /**
     * @param ProductCollection $subject
     * @param bool $printQuery
     * @param bool $logQuery
     * @return void
     */
    public function beforeLoad(ProductCollection $subject, bool $printQuery = false, bool $logQuery = false)
    {
        // Arguments can be omitted
        $class = get_class($subject);
        // Can optionally modify method arguments here and return them as array
        // return [true, true];
    }

    /**
     * @param ProductCollection $subject
     * @param Closure $proceed
     * @param bool $printQuery
     * @param bool $logQuery
     * @return ProductCollection
     */
    public function aroundLoad(
        ProductCollection $subject,
        Closure           $proceed,
        bool              $printQuery = false,
        bool              $logQuery = false
    ): ProductCollection
    {
        // Arguments must be accepted and passed to the $proceed call
        $result = $proceed($printQuery, $logQuery);
        $class = get_class($subject);
        return $result;
    }

    /**
     * @param ProductCollection $subject
     * @param $result
     * @return ProductCollection
     */
    public function afterLoad(ProductCollection $subject, $result /*, $printQuery = false, $logQuery = false*/): ProductCollection
    {
        // Arguments can be omitted
        // Can modify and return result if needed
        $class = get_class($subject);
        return $subject;
    }
}
