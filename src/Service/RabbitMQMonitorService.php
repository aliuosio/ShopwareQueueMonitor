<?php

declare(strict_types=1);

namespace QueueMonitor\Service;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQMonitorService
{
    public function checkStatus(): array
    {
        try {
            $result = [
                'status' => 'healthy',
                'message_count' => $this->canConnect()[1],
            ];
        } catch (\Exception $e) {
            $result = [
                'status' => 'unhealthy',
                'error' => $e->getMessage(),
            ];
        }

        return $result;
    }

    /**
     * @throws \Exception
     */
    private function canConnect(): ?array
    {
        $connection = new AMQPStreamConnection(
            getenv('RABBITMQ_HOST'),
            getenv('RABBITMQ_PORT'),
            getenv('RABBITMQ_USER'),
            getenv('RABBITMQ_PASSWORD')
        );

        return $connection->channel()->queue_declare('queue_monitor', true);
    }
}
