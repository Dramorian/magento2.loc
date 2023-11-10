<?php

namespace Alex\RequestSample\Setup;

use Alex\RequestSample\Model\RequestSample;
use Alex\RequestSample\Model\RequestSampleFactory;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\File\Csv;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Store\Model\Store;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var RequestSampleFactory
     */
    private $requestSampleFactory;

    /**
     * @var Csv
     */
    private $csv;

    /**
     * @var ComponentRegistrar
     */
    private $componentRegistrar;

    /**
     * UpgradeData constructor.
     * @param RequestSampleFactory $requestSampleFactory
     */
    public function __construct(
        RequestSampleFactory $requestSampleFactory,
        ComponentRegistrar   $componentRegistrar,
        Csv                  $csv
    )
    {
        $this->componentRegistrar = $componentRegistrar;
        $this->csv = $csv;
        $this->requestSampleFactory = $requestSampleFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $statuses = [RequestSample::STATUS_PENDING, RequestSample::STATUS_PROCESSED];

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
                $requestSample->save();
            }
        }

        if (version_compare($context->getVersion(), '1.0.3') < 0) {

            $this->updateDataForRequestSample($setup, 'import_data.csv');

        }
        $setup->endSetup();
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param $fileName
     * @throws \Exception
     */
    public function updateDataForRequestSample(ModuleDataSetupInterface $setup, $fileName)
    {
        $tableName = $setup->getTable('alex_request_sample');
        $file_path = $this->getPathToCsvMagentoAtdec($fileName);
        $csvData = $this->csv->getData($file_path);

        if ($setup->getConnection()->isTableExists($tableName) == true) {
            foreach ($csvData as $row => $data) {
                if (count($data) == 9) {
                    $res = $this->getCsvData($data);
                    $setup->getConnection()->insertOnDuplicate(
                        $tableName, $res,
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


