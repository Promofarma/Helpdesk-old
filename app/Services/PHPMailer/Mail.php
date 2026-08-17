<?php

declare(strict_types=1);

namespace App\Services\PHPMailer;

use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    public function __construct(
        private ?PHPMailer $mailer = null,
    ) {
        $this->mailer = new PHPMailer(true);

        $this->mailer->isSMTP();
        $this->mailer->setLanguage($_ENV['CONFIG_MAIL_LANGUAGE']);
        $this->mailer->isHTML($_ENV['CONFIG_MAIL_IS_HTML']);
        $this->mailer->SMTPAuth = $_ENV['CONFIG_MAIL_AUTH'];
        $this->mailer->SMTPSecure = $_ENV['CONFIG_MAIL_SECURE'];
        $this->mailer->CharSet = $_ENV['CONFIG_MAIL_CHARSET'];

        $this->mailer->Host = $_ENV['CONFIG_MAIL_HOST'];
        $this->mailer->Username = $_ENV['CONFIG_MAIL_USERNAME'];
        $this->mailer->Password = $_ENV['CONFIG_MAIL_PASSWORD'];
        $this->mailer->Port = $_ENV['CONFIG_MAIL_PORT'];
    }

    public function send(string $subject, string $message, array $from = []): bool
    {
        foreach ($from as $email) {
            $this->mailer->addAddress($email);
        }

        $this->mailer->setFrom('vinicius@promofarma.com.br');
        $this->mailer->Subject = $subject;
        $this->mailer->msgHTML($message);

        return $this->mailer->send();
    }
}
