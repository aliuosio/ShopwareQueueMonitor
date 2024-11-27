<?php

declare(strict_types=1);

namespace QueueMonitor\Service;

class RabbitMQMonitorService
{
    /**
     * @todo use symfony messenger qeue for RabbitMQ
     */
    public function checkStatus(): array
    {
        return [
            'status' => 'unhealthy',
            'error' => 'not good',
        ];
    }
}
