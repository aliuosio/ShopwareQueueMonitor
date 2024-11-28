<?php

declare(strict_types=1);

namespace QueueMonitor\Common;

trait MonitorTrait
{
    public function isUnhealthy(): bool
    {
        return 'unhealthy' == (bool) $this->monitorService->checkStatus()['status'];
    }

    private function notify(): void
    {
        $this->notifierService->run($this->monitorService->checkStatus()['error']);
    }

    public function action(): void
    {
        $this->action();
    }
}
