<?php

namespace Alex\RequestSample\Block;

use Alex\RequestSample\Model\ResourceModel\RequestSample\Collection;
use Alex\RequestSample\Model\ResourceModel\RequestSample\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Requests extends Template
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * Requests constructor.
     * @param CollectionFactory $collectionFactory
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Context           $context,
        array             $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return Collection
     */
    public function getSampleRequests(): Collection
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addStoreFilter()
            ->getSelect()
            ->orderRand();

        if ($limit = $this->getData('limit')) {
            $collection->setPageSize($limit);
        }

        return $collection;
    }
}
