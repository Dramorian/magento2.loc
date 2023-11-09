<?php

namespace Alex\RequestSample\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        // The code in install and upgrade scripts is the same
        // Though, right now this file  will not work because first version of this module did not have any models
        $foo = false;
    }
}
