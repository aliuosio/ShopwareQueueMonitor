<?php

declare(strict_types=1);

namespace QueueMonitor\Service;

use QueueMonitor\Service\NotifierService\EmailNotifier;
use QueueMonitor\Service\NotifierService\SlackNotifier;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class NotifierService
{
    public function __construct(
        readonly private iterable $notifiers,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function run(string $message, array $config): void
    {
        foreach ($this->notifiers as $notifier) {
            if ($notifier instanceof SlackNotifier && ($config['enableSlack'] ?? false)) {
                $notifier->notify($message);
            }

            if ($notifier instanceof EmailNotifier && ($config['enableEmail'] ?? false)) {
                $notifier->notify($message);
            }
        }
    }
}
