<?php

declare(strict_types=1);

namespace QueueMonitor\Service\NotifierService;

use QueueMonitor\Contract\NotifierInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SlackNotifier implements NotifierInterface
{
    public function __construct(
        readonly private HttpClientInterface $httpClient,
        readonly private string $webhookUrl,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function notify(string $message): void
    {
        $this->httpClient->request('POST', $this->webhookUrl, [
            'json' => ['text' => $message],
        ]);
    }
}
