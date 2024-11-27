<?php

declare(strict_types=1);

namespace QueueMonitor\Common;

use QueueMonitor\Service\NotifierService;
use QueueMonitor\Service\RabbitMQMonitorService;

trait MonitorTrait
{
    protected readonly RabbitMQMonitorService $monitorService;
    protected readonly NotifierService $notifierService;

    public function __construct(
        RabbitMQMonitorService $monitorService,
        NotifierService $notifierService
    ) {
        $this->monitorService = $monitorService;
        $this->notifierService = $notifierService;
    }

    public function isUnhealthy(): bool
    {
        return (bool)$this->monitorService->checkStatus()['status'] == 'unhealthy';
    }

    protected function notify(): void
    {
        $this->notifierService->run($this->monitorService->checkStatus()['error']);
    }
}
