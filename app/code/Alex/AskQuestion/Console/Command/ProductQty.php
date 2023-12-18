<?php

namespace Alex\AskQuestion\Console\Command;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProductQty extends Command
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var State
     */
    protected $appState;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param State $appState
     * @param string|null $name
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        State                      $appState,
        string                     $name = null
    )
    {
        parent::__construct($name);
        $this->productRepository = $productRepository;
        $this->appState = $appState;
    }

    protected function configure()
    {
        $this->setName('ask-question:update-product-qty')
            ->setDescription('Shows name and current product qty if only ID provided. With provided qty updates the amount in stock')
            ->addArgument('product_id', InputArgument::REQUIRED, 'Product ID')
            ->addArgument('qty', InputArgument::OPTIONAL, 'Quantity to set');
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $productId = $input->getArgument('product_id');
        $newQty = $input->getArgument('qty');

        try {
            // Set the area code to adminhtml to make repository work
            $this->appState->setAreaCode(Area::AREA_ADMINHTML);

            // Load product by ID
            $product = $this->productRepository->getById($productId);
            // If only product ID is provided, display current quantity
            if ($newQty === null) {
                $currentQty = $product->getExtensionAttributes()->getStockItem()->getQty();
                $productName = $product->getName();
                $output->writeln('<info>Product Name:</info> ' . $productName);
                $output->writeln('<info>Current Quantity:</info> ' . $currentQty);
                return Command::SUCCESS;
            }

            // If both product ID and new quantity are provided, update the quantity
            $product->getExtensionAttributes()->getStockItem()->setQty($newQty);
            $this->productRepository->save($product);

            $output->writeln('<info>Product quantity updated successfully!</info>');
            $output->writeln('<info>Updated Quantity:</info> ' . $newQty);
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln("Error: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
