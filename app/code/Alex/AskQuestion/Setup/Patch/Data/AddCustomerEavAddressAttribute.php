<?php

namespace Alex\AskQuestion\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\Attribute;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddCustomerEavAddressAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var Config
     */
    private $eavConfig;

    /**
     * @var Attribute
     */
    private $attributeResource;

    /**
     * @param EavSetupFactory $eavSetupFactory
     * @param Config $eavConfig
     * @param Attribute $attributeResource
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        EavSetupFactory          $eavSetupFactory,
        Config                   $eavConfig,
        Attribute                $attributeResource,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
        $this->attributeResource = $attributeResource;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * @return void
     * @throws AlreadyExistsException
     * @throws LocalizedException
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->addAddressAttribute();
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @return void
     * @throws AlreadyExistsException
     * @throws LocalizedException
     */
    public function addAddressAttribute()
    {
        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->addAttribute(
            Customer::ENTITY,
            'corpus',
            [
                'type' => 'varchar',
                'label' => 'Corpus',
                'input' => 'text',
                'required' => 0,
                'visible' => 1,
                'user_defined' => 1,
                'sort_order' => 999,
                'position' => 999,
                'system' => 0
            ]
        );

        $attributeSetId = $eavSetup->getDefaultAttributeSetId(Customer::ENTITY);
        $attributeGroupId = $eavSetup->getDefaultAttributeGroupId(Customer::ENTITY);

        $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'corpus');
        $attribute?->setData('attribute_set_id', $attributeSetId);
        $attribute?->setData('attribute_group_id', $attributeGroupId);

        $attribute?->setData('used_in_forms', [
            'adminhtml_customer',
            'adminhtml_customer_address',
            'customer_account_edit',
            'customer_address_edit',
            'customer_register_address',
            'customer_account_create'
        ]);

        if ($attribute !== null) {
            $this->attributeResource->save($attribute);
        }
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
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
