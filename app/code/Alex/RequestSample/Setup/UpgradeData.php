<?php

namespace Alex\RequestSample\Setup;

use Alex\RequestSample\Model\RequestSample;
use Alex\RequestSample\Model\RequestSampleFactory;
use Exception;
use Magento\Customer\Model\Attribute;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\DB\Transaction;
use Magento\Framework\DB\TransactionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\File\Csv;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Validator\ValidateException;
use Magento\Store\Model\Store;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var RequestSampleFactory
     */
    private $requestSampleFactory;

    /**
     * @var Csv $csv
     */
    private $csv;

    /**
     * @var ComponentRegistrar $componentRegistrar
     */
    private $componentRegistrar;

    /**
     * @var TransactionFactory
     */
    private $transactionFactory;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var Attribute
     */
    private $customerAttribute;

    /**
     * UpgradeData constructor
     *
     * @param RequestSampleFactory $requestSampleFactory
     * @param ComponentRegistrar $componentRegistrar
     * @param Csv $csv
     * @param TransactionFactory $transactionFactory
     * @param EavSetupFactory $eavSetupFactory
     * @param Attribute $customerAttribute
     */
    public function __construct(
        RequestSampleFactory $requestSampleFactory,
        ComponentRegistrar   $componentRegistrar,
        Csv                  $csv,
        TransactionFactory   $transactionFactory,
        EavSetupFactory      $eavSetupFactory,
        Attribute            $customerAttribute
    ) {
        $this->requestSampleFactory = $requestSampleFactory;
        $this->componentRegistrar = $componentRegistrar;
        $this->csv = $csv;
        $this->transactionFactory = $transactionFactory;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->customerAttribute = $customerAttribute;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws LocalizedException
     * @throws ValidateException
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $statuses = [RequestSample::STATUS_PENDING, RequestSample::STATUS_PROCESSED];
            /** @var Transaction $transaction */
            $transaction = $this->transactionFactory->create();

            for ($i = 1; $i <= 5; $i++) {
                /** @var RequestSample $requestSample */
                $requestSample = $this->requestSampleFactory->create();
                $requestSample->setName("Customer #$i")
                    ->setEmail("test-mail-$i@gmail.com")
                    ->setPhone("+38093-$i$i$i-$i$i-$i$i")
                    ->setProductName("Product #$i")
                    ->setSku("product_sku_$i")
                    ->setRequest('Just a test request')
                    ->setStatus($statuses[array_rand($statuses)])
                    ->setStoreId(Store::DISTRO_STORE_ID);
                $transaction->addObject($requestSample);
                $requestSample->save();
            }
            $transaction->save();
        }

        if (version_compare($context->getVersion(), '1.0.3') < 0) {

            $this->updateDataForRequestSample($setup, 'import_data.csv');

        }

        if (version_compare($context->getVersion(), '1.0.4') < 0) {
            $this->createAllowRequestSampleCustomerAttribute($setup);
        }
        $setup->endSetup();
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param $fileName
     * @throws Exception
     */
    public function updateDataForRequestSample(ModuleDataSetupInterface $setup, $fileName)
    {
        $tableName = $setup->getTable('alex_request_sample');
        $filePath = $this->getPathToCsvMagentoAtdec($fileName);
        $csvData = $this->csv->getData($filePath);

        if ($setup->getConnection()->isTableExists($tableName)) {
            foreach ($csvData as $row => $data) {
                if (count($data) === 9) {
                    $res = $this->getCsvData($data);
                    $setup->getConnection()->insertOnDuplicate(
                        $tableName,
                        $res,
                        [
                            'name',
                            'email',
                            'phone',
                            'product_name',
                            'sku',
                            'request',
                            'created_at',
                            'status',
                            'store_id',
                        ]);
                }
            }
        }
    }

    /**
     * @param $setup
     * @return void
     * @throws LocalizedException
     * @throws ValidateException
     * @throws Exception
     */
    public function createAllowRequestSampleCustomerAttribute($setup)
    {
        $code = 'allow_request_sample';
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            Customer::ENTITY,
            'allow_request_sample',
            [
                'type' => 'int',
                'label' => 'Allow request sample',
                'input' => 'boolean',
                'source' => Boolean::class,
                'required' => false,
                'visible' => false,
                'user_defined' => true,
                'position' => 999,
                'system' => 0,
                'default' => 1,
                'used_in_forms' => ['adminhtml_customer', 'customer_account_edit'],
            ]
        );

        $attribute = $this->customerAttribute->loadByCode(Customer::ENTITY, $code);

        $attribute->addData([
            'attribute_set_id' => 1,
            'attribute_group_id' => 1,
            'used_in_forms' => ['adminhtml_customer', 'customer_account_edit'],
        ])->save();
    }

    /**
     * @param $fileName
     * @return string
     */
    private function getPathToCsvMagentoAtdec($fileName)
    {
        return $this->componentRegistrar->getPath(ComponentRegistrar::MODULE, 'Alex_RequestSample') .
            DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * @param $data
     * @return array
     */
    private function getCsvData($data)
    {
        return [
            'name' => $data[0],
            'email' => $data[1],
            'phone' => $data[2],
            'product_name' => $data[3],
            'sku' => $data[4],
            'request' => $data[5],
            'created_at' => $data[6],
            'status' => $data[7],
            'store_id' => $data[8],
        ];
    }
}


