<?php

declare(strict_types=1);

namespace QueueMonitor\ScheduledTask;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandlerInterface;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckRabbitMQTaskHandler implements ScheduledTaskHandlerInterface
{
    /**
     * @return bool
     */
    public function isUnhealthy(): bool
    {
        return (bool)$this->monitorService->checkStatus()['status'] == 'unhealthy';
    }

    public function run(ScheduledTask $scheduledTask): void
    {
        if ($this->isUnhealthy()) {
            $message = 'RabbitMQ queue is down.';
            $this->notifierService->run($message);
        }
    }
}
