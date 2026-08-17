<?php

declare(strict_types=1);

namespace App\Services\Notification;

use App\Services\Notification\Contracts\Mailable;
use App\Services\PHPMailer\Mail;
use RuntimeException;

abstract class Notification implements Mailable
{
    abstract protected function subject(): string;

    abstract protected function to(): array;

    abstract protected function message(): string;

    public function send(): bool
    {
        if (strlen($this->subject()) === 0 || $this->subject() === '') {
            throw new RuntimeException('Subject is empty');
        }

        if (strlen($this->message()) === 0 || $this->message() === '') {
            throw new RuntimeException('Message is empty');
        }

        if (empty($this->to())) {
            throw new RuntimeException('To e-mails list is empty');
        }

        $mailer = new Mail();

        return $mailer->send($this->subject(), $this->message(), $this->to());
    }
}
