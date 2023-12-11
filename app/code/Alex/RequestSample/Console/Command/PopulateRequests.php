<?php

namespace Alex\RequestSample\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateRequests extends Command
{

    public const DEFAULT_COUNT = 20;

    protected function configure()
    {
        $this->setName('request-sample:populate-requests')
            ->setDescription('Populate requests')
            ->setDefinition([
                new InputArgument(
                    'count',
                    InputArgument::OPTIONAL,
                    'Count'
                )
            ]);
        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $count = $input->getArgument('count') ?: self::DEFAULT_COUNT;
        $i = 0;

        while ($i < $count) {
            ++$i;
            $output->writeln("<info>Generated item #$i...<info>");
        }

        $output->writeln("<info>Completed!<info>");
        return 0; // Return an integer value as required
    }
}
