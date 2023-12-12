<?php

namespace Alex\RequestSample\Cron;

use Psr\Log\LoggerInterface;

class Example
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Example constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute()
    {
        $this->logger->critical('Cron job is not implemented yet!');
    }
}
