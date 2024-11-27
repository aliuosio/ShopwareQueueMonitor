<?php

namespace QueueMonitor\ScheduledTask;

use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;

class Register extends ScheduledTask
{
    public static function getTaskName(): string
    {
        return 'queue_monitor.scheduled.task';
    }

    public static function getDefaultInterval(): int
    {
        return 300;
    }
}
