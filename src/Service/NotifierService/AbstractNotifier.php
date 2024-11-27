<?php

declare(strict_types=1);

namespace QueueMonitor\Service\NotifierService;

use QueueMonitor\Contract\NotifierInterface;
use RuntimeException;
use Shopware\Core\System\SystemConfig\SystemConfigService;

abstract class AbstractNotifier implements NotifierInterface
{
    public function __construct(
        protected SystemConfigService $configService
    ) {
    }
    public function notify(string $message): void
    {
        if (!$this->hasNotificationEnabled()) {
            return;
        }

        if (!$this->getRecipientOrUrl()) {
            throw new RuntimeException($this->getMissingRecipientMessage());
        }

        $this->send($message);
    }

    abstract public function hasNotificationEnabled(): bool;

    abstract protected function send(string $message): void;

    abstract protected function getRecipientOrUrl(): ?string;

    abstract protected function getMissingRecipientMessage(): string;
}
