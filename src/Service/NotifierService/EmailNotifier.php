<?php

declare(strict_types=1);

namespace QueueMonitor\Service\NotifierService;

use Shopware\Core\System\SystemConfig\SystemConfigService;

class EmailNotifier
{
    public function __construct(
        readonly private SystemConfigService $configService,
    ) {
    }

    public function notify(string $message): void
    {
        if (!$this->getRecipient()) {
            throw new \RuntimeException('Email recipient is not configured.');
        }
    }

    private function getRecipient(): ?string
    {
        return $this->configService->get('QueueMonitor.config.email_recipient') ?? 'default@example.com';
    }
}
