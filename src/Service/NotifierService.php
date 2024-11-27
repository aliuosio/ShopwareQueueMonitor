<?php

declare(strict_types=1);

namespace QueueMonitor\Service;

use Shopware\Core\System\SystemConfig\SystemConfigService;

class NotifierService
{
    private SystemConfigService $configService;
    private iterable $notifiers;

    public function __construct(SystemConfigService $configService, iterable $notifiers)
    {
        $this->configService = $configService;
        $this->notifiers = $notifiers;
    }

    public function run(string $message): void
    {
        foreach ($this->notifiers as $notifier) {
            $notifier->notify($message);
        }
    }
}
