<?php

namespace Alex\SalesRule\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Upgrade the SalesRule module DB scheme
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @inheritdoc
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $installer->getConnection()
            ->addColumn(
                $installer->getTable('salesrule'),
                'apply_action_on',
                [
                    'type'     => Table::TYPE_TEXT,
                    'nullable' => true,
                    'default'  => null,
                    'length'   => 31,
                    'comment'  => 'Apply Action On',
                    'after'    => 'simple_action'
                ]
            );

        $installer->endSetup();
    }
}
