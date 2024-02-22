<?php

namespace Overdose\CronCliApi\Console\Command;

use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunCommand extends Command
{

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('overdose:cli')
            ->setDescription('Does something important');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>Test run</info>");

        return 0;
    }
}
