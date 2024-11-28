<?php

declare(strict_types=1);

namespace QueueMonitor\Command;

use QueueMonitor\Common\MonitorTrait;
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
    use MonitorTrait;

    public function __construct(
        private readonly RabbitMQMonitorService $monitorService,
        private readonly NotifierService $notifierService,
        ?string $name = null,
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->isUnhealthy()) {
            $this->notify();
        }

        $output->writeln('Queue monitoring executed.');

        return Command::SUCCESS;
    }
}
