<?php

declare(strict_types=1);

namespace QueueMonitor\Contract;

interface NotifierInterface
{
    public function notify(string $message): void;
}
