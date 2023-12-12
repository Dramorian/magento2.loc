<?php

namespace Alex\RequestSample\Console\Command;

use Alex\RequestSample\Model\RequestSampleFactory;
use Alex\RequestSample\Model\RequestSampleGenerator;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\DB\TransactionFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateRequests extends Command
{
    public const DEFAULT_COUNT = 20;

    /**
     * @var RequestSampleGenerator
     */
    private $requestSampleGenerator;

    /**
     * @var State
     */
    private $state;

    /**
     * @param RequestSampleGenerator $requestSampleGenerator
     * @param State $state
     * @param string|null $name
     */
    public function __construct(
        RequestSampleGenerator $requestSampleGenerator,
        State                  $state,
        string                 $name = null
    ) {
        parent::__construct($name);
        $this->state = $state;
        $this->requestSampleGenerator = $requestSampleGenerator;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('request-sample:populate-requests')
            ->setDescription('Populate sample requests. Can pass `count` argument')
            ->setDefinition([
                new InputArgument(
                    'count',
                    InputArgument::OPTIONAL,
                    'Count'
                )
            ]);
        parent::configure();
    }

    /**
     * @inheritdoc
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->state->emulateAreaCode(
                Area::AREA_ADMINHTML,
                function (int $count) use ($output) {
                    foreach ($this->requestSampleGenerator->generate($count) as $message) {
                        $output->writeln("<info>$message</info>");
                    }
                },
                [
                    $input->getArgument('count') ?: self::DEFAULT_COUNT
                ]
            );
        } catch (\Exception $e) {
            $output->writeln("<error>{$e->getMessage()}<error>");
        }
        return 0;
    }
}
