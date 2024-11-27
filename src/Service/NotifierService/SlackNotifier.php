<?php

declare(strict_types=1);

namespace QueueMonitor\Service\NotifierService;

use QueueMonitor\Contract\NotifierInterface;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SlackNotifier implements NotifierInterface
{
    public function __construct(
        readonly private SystemConfigService $configService,
        readonly private HttpClientInterface $httpClient,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function notify(string $message): void
    {
        $this->httpClient->request(
            'POST',
            $this->getWebHookURL(),
            ['json' => ['text' => $message]]
        );
    }

    private function getWebHookURL(): array|float|bool|int|string|null
    {
        return $this->configService->get('QueueMonitor.config.slack_webhook_Url') ?? 'https://foobar.de';
    }
}
