<?php

declare(strict_types=1);

namespace QueueMonitor\ScheduledTask;

use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;

class QueueMonitorTaskHandler extends ScheduledTask
{
    public static function getTaskName(): string
    {
        return 'queue_monitor';
    }

    public static function getDefaultInterval(): int
    {
        return 300;
    }
}
