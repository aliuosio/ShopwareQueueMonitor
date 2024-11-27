<?php

declare(strict_types=1);

namespace QueueMonitor\Service;

class NotifierService
{

    public function __construct(
        readonly private iterable $notifiers
    )
    {}

    public function run(string $message): void
    {
        foreach ($this->notifiers as $notifier) {
            $notifier->notify($message);
        }
    }
}
