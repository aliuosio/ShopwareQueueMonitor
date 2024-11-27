<?php

declare(strict_types=1);

namespace QueueMonitor\Service\NotifierService;

use QueueMonitor\Contract\NotifierInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailNotifier implements NotifierInterface
{
    public function __construct(
        readonly private MailerInterface $mailer,
        readonly private string $recipient,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function notify(string $message): void
    {
        $email = (new Email())
            ->from('no-reply@example.com')
            ->to($this->recipient)
            ->subject('Queue Monitor Alert')
            ->text($message);

        $this->mailer->send($email);
    }
}
