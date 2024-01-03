<?php

namespace Alex\Lesson10\Model\Config\Backend;

use Exception;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\App\Config\ValueFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

/**
 * Class Custom
 * @package Alex\Lesson10\Model\Config\Backend
 */
class Custom extends Value
{
    /**
     * @var ValueFactory
     */
    protected $configValue;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param ValueFactory $configValueFactory
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context              $context,
        Registry             $registry,
        ScopeConfigInterface $config,
        TypeListInterface    $cacheTypeList,
        ValueFactory         $configValueFactory,
        AbstractResource     $resource = null,
        AbstractDb           $resourceCollection = null,
        array                $data = []
    )
    {
        $this->configValue = $configValueFactory;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * @return void
     * @throws ValidatorException
     */
    public function beforeSave()
    {
        $label = $this->getData('field_config/label');

        if ($this->getValue() == '') {
            throw new ValidatorException(__($label . ' is required.'));
        } else if (is_numeric($this->getValue())) {
            throw new ValidatorException(__($label . ' is not a text.'));
        } else if (strlen($this->getValue()) < 5) {
            throw new ValidatorException(__($label . ' word is too short, Minimum 5 letters'));
        }

        $this->setValue($this->getValue());

        parent::beforeSave();
    }

    /**
     * @throws Exception
     */
    public function afterSave()
    {

        $value = $this->getValue();

        try {
            $this->configValue->create()->load(
                'alex_cron_options/general/display_text_dis',
                'path'
            )->setValue(
                $value
            )->setPath(
                'alex_cron_options/general/display_text_dis'
            )->save();
        } catch (Exception $e) {
            throw new Exception(__('We can\'t save new option.'));
        }


        return parent::afterSave();
    }
}
