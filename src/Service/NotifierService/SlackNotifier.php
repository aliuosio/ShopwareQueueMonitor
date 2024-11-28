<?php

declare(strict_types=1);

namespace QueueMonitor\Service\NotifierService;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SlackNotifier extends AbstractNotifier
{
    public function __construct(
        protected SystemConfigService $configService,
        private readonly HttpClientInterface $httpClient,
    ) {
        parent::__construct($configService);
    }

    public function hasNotificationEnabled(): bool
    {
        return (bool) $this->configService->get('QueueMonitor.config.enableSlack');
    }

    /**
     * @throws TransportExceptionInterface
     */
    protected function send(string $message): void
    {
        $this->httpClient->request(
            'POST',
            $this->getRecipientOrUrl(),
            ['json' => ['text' => $message]]
        );
    }

    protected function getRecipientOrUrl(): ?string
    {
        return $this->configService->get('QueueMonitor.config.slackWebhookUrl');
    }

    protected function getMissingRecipientMessage(): string
    {
        return 'No Webhook URL configured.';
    }
}
