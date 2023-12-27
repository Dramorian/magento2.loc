<?php

namespace Alex\AskQuestion\Model\Config\Source;

use Exception;
use Magento\Cron\Model\Config\Source\Frequency;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\App\Config\ValueFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class CronConfig extends Value
{
    /**
     * Cron string path constant
     */
    public const CRON_STRING_PATH = 'crontab/default/jobs/alex_askquestion_change_status/schedule/cron_expr';

    /**
     * Cron model path constant
     */
    public const CRON_MODEL_PATH = 'crontab/default/jobs/alex_askquestion_change_status/run/model';

    /**
     * @var ValueFactory
     */
    protected $_configValueFactory;

    /**
     * @var mixed|string
     */
    protected mixed $_runModelPath = '';

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param ValueFactory $configValueFactory
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param $runModelPath
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
                             $runModelPath = '',
        array                $data = []
    ) {
        $this->_runModelPath = $runModelPath;
        $this->_configValueFactory = $configValueFactory;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }


    /**
     * @return CronConfig
     * @throws Exception
     */
    public function afterSave()
    {
        $time = $this->getData('groups/configurable_cron/fields/time/value');
        $frequency = $this->getData('groups/configurable_cron/fields/frequency/value');
        $cronExprArray = [
            (int)$time[1], //Minute
            (int)$time[0], //Hour
            $frequency === Frequency::CRON_MONTHLY ? '1' : '*', //Day of the Month
            '*', //Month of the Year
            $frequency === Frequency::CRON_WEEKLY ? '1' : '*', //Day of the Week
        ];
        $cronExprString = implode(' ', $cronExprArray);

        try {
            $this->_configValueFactory->create()->load(
                self::CRON_STRING_PATH,
                'path'
            )->setValue(
                $cronExprString
            )->setPath(
                self::CRON_STRING_PATH
            )->save();
            $this->_configValueFactory->create()->load(
                self::CRON_MODEL_PATH,
                'path'
            )->setValue(
                $this->_runModelPath
            )->setPath(
                self::CRON_MODEL_PATH
            )->save();
        } catch (\Exception $e) {
            throw new \Exception(__('We can\'t save the cron expression.'));
        }
        return parent::afterSave();
    }
}
