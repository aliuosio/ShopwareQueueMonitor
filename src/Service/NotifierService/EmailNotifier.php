<?php

declare(strict_types=1);

namespace QueueMonitor\Service\NotifierService;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailNotifier extends AbstractNotifier
{
    public function __construct(
        protected SystemConfigService $configService,
        private readonly MailerInterface $mailer
    ) {
        parent::__construct($configService);
    }

    public function hasNotificationEnabled(): bool
    {
        return (bool) $this->configService->get('QueueMonitor.config.enableEmail');
    }

    /**
     * @throws TransportExceptionInterface
     */
    protected function send(string $message): void
    {
        $email = (new Email())
            ->from('no-reply@example.com')
            ->to($this->getRecipientOrUrl())
            ->subject('Queue went bad')
            ->text($message)
            ->html('<p>' . nl2br($message) . '</p>');

        $this->mailer->send($email);
    }

    protected function getRecipientOrUrl(): ?string
    {
        return $this->configService->get('QueueMonitor.config.emailRecipient');
    }

    protected function getMissingRecipientMessage(): string
    {
        return 'Email recipient is not configured.';
    }
}
