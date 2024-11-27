<?php

declare(strict_types=1);

namespace QueueMonitor\Service\NotifierService;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailNotifier
{
    public function __construct(
        readonly private SystemConfigService $configService,
        readonly private MailerInterface $mailer,
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     *
     * @todo refactor
     */
    public function notify(string $message): void
    {
        if ($this->hasEmailNotify()) {
            if (!$this->getRecipient()) {
                throw new \RuntimeException('Email recipient is not configured.');
            }

            $email = (new Email())
                ->from('no-reply@example.com')
                ->to($this->getRecipient())
                ->subject('Queue went bad')
                ->text($message)
                ->html('<p>' . nl2br($message) . '</p>');

            $this->mailer->send($email);
        }
    }

    private function getRecipient(): ?string
    {
        return $this->configService->get('QueueMonitor.config.emailRecipient') ?? 'default@example.com';
    }

    private function hasEmailNotify(): bool
    {
        return $this->configService->get('QueueMonitor.config.enableEmail');
    }
}
