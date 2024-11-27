<?php

declare(strict_types=1);

namespace QueueMonitor\Service;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQMonitorService
{
    /**
     * @todo use symfony messenger qeue for RabbitMQ
     */
    public function checkStatus(): array
    {
        $result = [
            'status' => 'unhealthy',
            'error' => 'not good',
        ];

        /**
        try {
            $connection = new AMQPStreamConnection('rabbitmq_host', 5672, 'user', 'password');
            $channel = $connection->channel();
            $queueStatus = $channel->queue_declare('queue_name', true);

            $result = [
                'status' => 'healthy',
                'message_count' => $queueStatus[1],
            ];
        } catch (\Exception $e) {
            $result = [
                'status' => 'unhealthy',
                'error' => $e->getMessage(),
            ];
        }
         */

        return $result;
    }
}
