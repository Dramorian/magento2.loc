<?php

namespace Alex\RequestSample\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Alex\RequestSample\Model\RequestSample;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @inheritdoc
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            /**
             * Create table 'alex_request_sample'
             */
            $table = $installer->getConnection()->newTable(
                $installer->getTable('alex_request_sample')
            )->addColumn(
                'request_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Request ID'
            )->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Customer Name'
            )->addColumn(
                'email',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Customer Email'
            )->addColumn(
                'phone',
                Table::TYPE_TEXT,
                63,
                [],
                'Phone'
            )->addColumn(
                'product_name',
                Table::TYPE_TEXT,
                127,
                ['nullable' => false],
                'Product Name'
            )->addColumn(
                'sku',
                Table::TYPE_TEXT,
                63,
                ['nullable' => false],
                'Sku'
            )->addColumn(
                'request',
                Table::TYPE_TEXT,
                63,
                ['nullable' => false],
                'Request'
            )->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Creation Time'
            )->addColumn(
                'status',
                Table::TYPE_TEXT,
                15,
                ['nullable' => false, 'default' => RequestSample::STATUS_PENDING],
                'Status'
            )->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                5,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )->addForeignKey(
                $installer->getFkName(
                    $installer->getTable('alex_request_sample'),
                    'store_id',
                    'store',
                    'store_id'
                ),
                'store_id',
                $installer->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE,
                Table::ACTION_CASCADE
            )->setComment(
                'Request a Sample'
            );

            $installer->getConnection()->createTable($table);
        }

        if (version_compare($context->getVersion(), '1.0.5', '<')) {

            /**
             * Add column 'Customer id to 'alex_request_sample'
             */
            $tableName = $setup->getTable('alex_request_sample');
            if ($setup->getConnection()->isTableExists($tableName) === true) {
                $connection = $setup->getConnection();
                $connection->addColumn(
                    $tableName,
                    'customer_id',
                    [
                        'type' => Table::TYPE_INTEGER,
                        'nullable' => true,
                        'comment' => 'Customer ID',
                    ]
                );

                // @todo foreign key failed, fix
//                $connection ->addForeignKey(
//                    $setup->getFkName($tableName, 'customer_id', 'customer_entity', 'entity_id'),
//                    $tableName,
//                    'customer_id',
//                    $setup->getTable('customer_entity'),
//                    'entity_id',
//                    Table::ACTION_CASCADE
//                );
            }
        }

        $installer->endSetup();
    }
}
