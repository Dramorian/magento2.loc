<?php

namespace Alex\RequestSample\Model;

use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\DB\Transaction;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\DB\TransactionFactory;

class RequestSampleGenerator
{
    /**
     * @var \Magento\Catalog\Model\ProductRepository\Proxy
     */
    private $productRepository;
    /**
     * @var SearchCriteria
     */
    private $criteria;
    /**
     * @var TransactionFactory
     */
    private $transactionFactory;
    /**
     * @var RequestSampleFactory
     */
    private $requestSampleFactory;

    /**
     * RequestSampleGenerator constructor.
     * @param \Magento\Catalog\Model\ProductRepository\Proxy $productRepository
     * @param SearchCriteria $criteria
     * @param TransactionFactory $transactionFactory
     * @param RequestSampleFactory $requestSampleFactory
     */
    public function __construct(
        \Magento\Catalog\Model\ProductRepository\Proxy $productRepository,
        SearchCriteria $criteria,
        TransactionFactory $transactionFactory,
        RequestSampleFactory $requestSampleFactory
    ) {
        $this->productRepository = $productRepository;
        $this->criteria = $criteria;
        $this->transactionFactory = $transactionFactory;
        $this->requestSampleFactory = $requestSampleFactory;
    }

    /**
     * @param int $count
     * @return \Generator
     * @throws \Exception
     */
    public function generate(int $count): \Generator
    {
        $i = 0;
        /** @var Transaction $transaction */
        $transaction = $this->transactionFactory->create();
        $this->criteria->setPageSize(100);
        $products = $this->productRepository->getList($this->criteria)
            ->getItems();

        while ($i < $count) {
            ++$i;
            /** @var ProductInterface $product */
            $product = $products[array_rand($products)];

            /** @var RequestSample $requestSample */
            $requestSample = $this->requestSampleFactory->create();
            $requestSample->setName("Test name $i")
                ->setEmail("email-$i@example.com")
                ->setPhone('888-88-88')
                ->setProductName($product->getName())
                ->setSku($product->getSku())
                ->setRequest("Lorem ipsum #$i");

            $transaction->addObject($requestSample);
            yield "Generated item #$i...";
        }

        $transaction->save();
        yield "Completed!";
    }
}
