<?php

declare(strict_types=1);

namespace QueueMonitor\ScheduledTask;

use Psr\Log\LoggerInterface;
use QueueMonitor\Common\MonitorTrait;
use QueueMonitor\Service\NotifierService;
use QueueMonitor\Service\RabbitMQMonitorService;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: QueueMonitorTaskHandler::class)]
class QueueMonitorTask extends ScheduledTaskHandler
{
    use MonitorTrait;

    public function __construct(
        private readonly RabbitMQMonitorService $monitorService,
        private readonly NotifierService $notifierService,
        EntityRepository $scheduledTaskRepository,
        ?LoggerInterface $exceptionLogger = null,
    ) {
        parent::__construct($scheduledTaskRepository, $exceptionLogger);
    }

    public function run(): void
    {
        $this->action();
    }
}
