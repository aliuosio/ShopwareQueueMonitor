<?php

namespace QueueMonitor\Contract;

interface NotifierInterface
{
    public function notify(string $message): void;
}
