<?php

namespace Alex\RequestSample\Console\Command;

use Alex\RequestSample\Model\RequestSample;
use Alex\RequestSample\Model\RequestSampleFactory;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\DB\Transaction;
use Magento\Framework\DB\TransactionFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateRequests extends Command
{
    public const DEFAULT_COUNT = 20;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var SearchCriteria
     */
    private $criteria;

    /**
     * @var RequestSampleFactory
     */
    private $requestSampleFactory;

    /**
     * @var TransactionFactory
     */
    private $transactionFactory;

    /**
     * @var State
     */
    private $state;

    /**
     * PopulateRequests constructor.
     * @param ProductRepository $productRepository
     * @param SearchCriteria $criteria
     * @param RequestSampleFactory $requestSampleFactory
     * @param TransactionFactory $transactionFactory
     * @param State $state
     * @param string|null $name
     */
    public function __construct(
        ProductRepository    $productRepository,
        SearchCriteria       $criteria,
        RequestSampleFactory $requestSampleFactory,
        TransactionFactory   $transactionFactory,
        State                $state,
        string               $name = null
    ) {
        parent::__construct($name);
        $this->productRepository = $productRepository;
        $this->criteria = $criteria;
        $this->requestSampleFactory = $requestSampleFactory;
        $this->transactionFactory = $transactionFactory;
        $this->state = $state;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('request-sample:populate-requests')
            ->setDescription('Populate sample requests. Can pass `count` argument')
            ->setDefinition([
                new InputArgument(
                    'count',
                    InputArgument::OPTIONAL,
                    'Count'
                )
            ]);
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->state->setAreaCode(Area::AREA_ADMINHTML);
            $count = $input->getArgument('count') ?: self::DEFAULT_COUNT;
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
                $output->writeln("<info>Generated item #$i...<info>");
            }

            $transaction->save();
            $output->writeln("<info>Completed!<info>");
        } catch (\Exception $e) {
            $output->writeln("<error>{$e->getMessage()}<error>");

        }
        return 0;
    }
}
