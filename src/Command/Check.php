<?php

declare(strict_types=1);

namespace QueueMonitor\Command;

use QueueMonitor\Service\NotifierService;
use QueueMonitor\Service\RabbitMQMonitorService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'queue:monitor',
    description: 'Monitor Mail Queue and send notifications on failure',
)]
class Check extends Command
{
    public function __construct(
        readonly private RabbitMQMonitorService $monitorService,
        readonly private NotifierService $notifierService,
        readonly ?string $name = null,
    ) {
        parent::__construct($name);
    }

    public function isUnhealthy(): bool
    {
        return (bool)$this->monitorService->checkStatus()['status'] == 'unhealthy';
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->isUnhealthy()) {
            $message = 'RabbitMQ queue is down.';
            $this->notifierService->run($message);
        }

        $output->writeln('Queue monitoring executed.');
        return Command::SUCCESS;
    }
}
