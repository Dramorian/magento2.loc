<?php

namespace Alex\AskQuestion\Setup\Patch\Schema;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;

class AddCustomerIdColumn implements SchemaPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        // Get the table name
        $tableName = $this->moduleDataSetup->getTable('alex_ask_question');

        // Add the new column 'customer_id'
        $this->moduleDataSetup->getConnection()->addColumn(
            $tableName,
            'customer_id',
            [
                'type' => Table::TYPE_INTEGER,
                'nullable' => true,
                'comment' => 'Customer ID'
            ]
        );

        $this->moduleDataSetup->endSetup();
    }

    /**
     * Revert the patch
     *
     * @return void
     */
    public function revert()
    {
        $this->moduleDataSetup->startSetup();

        // Get the table name
        $tableName = $this->moduleDataSetup->getTable('alex_ask_question');

        // Remove the column 'customer_id'
        $this->moduleDataSetup->getConnection()->dropColumn($tableName, 'customer_id');

        $this->moduleDataSetup->endSetup();
    }

    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @return string
     */
    public static function getVersion(): string
    {
        return '1.0.1';
    }
}
