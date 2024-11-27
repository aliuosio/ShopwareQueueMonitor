<?php

declare(strict_types=1);

namespace QueueMonitor\Service;

use QueueMonitor\Service\NotifierService\EmailNotifier;
use QueueMonitor\Service\NotifierService\SlackNotifier;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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
