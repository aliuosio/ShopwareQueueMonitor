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
use Symfony\Component\Messenger\Exception\ExceptionInterface;

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

    /**
     * @throws ExceptionInterface
     */
    public function run(): void
    {
        $this->action();
    }
}
