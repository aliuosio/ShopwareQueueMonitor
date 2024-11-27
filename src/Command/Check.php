<?php

declare(strict_types=1);

namespace QueueMonitor\Command;

use QueueMonitor\Service\NotifierService;
use QueueMonitor\Service\RabbitMQMonitorService;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsCommand(
    name: 'queue:monitor',
    description: 'Monitor Mail Queue and send notifications on failure',
)]
class Check extends Command
{
    public function __construct(
        readonly private RabbitMQMonitorService $monitorService,
        readonly private NotifierService $notifierService,
        readonly private SystemConfigService $configService,
        readonly ?string $name = null,
    ) {
        parent::__construct($name);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $config = $this->configService->get('QueueMonitor.config.notifiers');

        if (!$this->monitorService->checkStatus()) {
            $message = 'RabbitMQ queue is down.';
            $this->notifierService->run($message, $config);
        }

        $output->writeln('Queue monitoring executed.');
        return Command::SUCCESS;
    }
}
