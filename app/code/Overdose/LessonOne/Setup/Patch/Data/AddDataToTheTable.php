<?php

namespace Overdose\LessonOne\Setup\Patch\Data;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Overdose\LessonOne\Model\FriendsFactory;
use Overdose\LessonOne\Model\ResourceModel\Friends;

class AddDataToTheTable implements DataPatchInterface
{

    /**
     * @var ModuleDataSetupInterface
     */
    protected $moduleDataSetup;

    /**
     * @var FriendsFactory
     */
    protected $friendsFactory;

    /**
     * @var Friends
     */
    protected $friendsResourceModel;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        FriendsFactory           $friendsFactory,
        Friends                  $friendsResourceModel
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->friendsFactory = $friendsFactory;
        $this->friendsResourceModel = $friendsResourceModel;
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritDoc
     * @throws AlreadyExistsException
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        for ($i = 0; $i < 10; $i++) {
            $model = $this->friendsFactory->create();

            $model->setData('name', $i)
                ->setData('age', $i)
                ->setData('comment', $i);

            $this->friendsResourceModel->save($model);
        }

        $this->moduleDataSetup->endSetup();
    }
}
