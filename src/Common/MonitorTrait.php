<?php

declare(strict_types=1);

namespace QueueMonitor\Common;

use Symfony\Component\Messenger\Exception\ExceptionInterface;

trait MonitorTrait
{
    /**
     * @throws ExceptionInterface
     */
    public function isUnhealthy(): bool
    {
        return 'unhealthy' == (bool) $this->monitorService->checkStatus()['status'];
    }

    /**
     * @throws ExceptionInterface
     */
    private function notify(): void
    {
        $this->notifierService->run($this->monitorService->checkStatus()['error']);
    }

    /**
     * @throws ExceptionInterface
     */
    public function action(): void
    {
        if ($this->isUnhealthy()) {
            $this->notify();
        }
    }
}
