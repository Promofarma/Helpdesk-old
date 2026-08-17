<?php

declare(strict_types=1);

namespace App\Services\Notification;

use DateTime;

class NotifyWhenSubjectIsDigitalOrder extends Notification
{
    private const DIGITAL_ORDER_RECIPIENTS = [
        'allyah.goncalves@promofarma.com.br',
        'amanda.silva@promofarma.com.br',
    ];

    public function __construct(
        private object $ticket,
    ) {}

    protected function subject(): string
    {
        return sprintf(
            'Chamado: #%d - %s - %s',
            $this->ticket->TICKET_CHAMADO,
            $this->ticket->TITULO,
            $this->ticket->USUARIO,
        );
    }

    protected function message(): string
    {
        $content = json_decode($this->ticket->MENSAGEM, true) ?? [];

        $description = htmlspecialchars($content['DESCRIPTION'] ?? '-', ENT_QUOTES, 'UTF-8');
        $message = htmlspecialchars($content['MESSAGE'] ?? '-', ENT_QUOTES, 'UTF-8');
        $username = htmlspecialchars($this->ticket->USUARIO, ENT_QUOTES, 'UTF-8');
        $employee = htmlspecialchars($this->ticket->NOME_BALCONISTA, ENT_QUOTES, 'UTF-8');
        $createdAt = new DateTime($this->ticket->INICIALIZACAO);

        return "
            <table role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" style=\"border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#333333;\">
                <tr><td style=\"padding:0 0 16px 0;\">Detalhes do Chamado aberto por: <strong>{$username}</strong></td></tr>
                <tr><td style=\"padding:0 0 4px 0;font-size:16px;font-weight:bold;\">Descrição</td></tr>
                <tr><td style=\"padding:0 0 16px 0;\">{$description}</td></tr>
                <tr><td style=\"padding:0 0 4px 0;font-size:16px;font-weight:bold;\">Mensagem</td></tr>
                <tr><td style=\"padding:0 0 16px 0;\">{$message}</td></tr>
                <tr><td style=\"padding:0 0 4px 0;font-size:16px;font-weight:bold;\">Aberto por</td></tr>
                <tr><td style=\"padding:0 0 16px 0;\">{$employee}</td></tr>
                <tr><td style=\"padding:0 0 4px 0;font-size:16px;font-weight:bold;\">Aberto em</td></tr>
                <tr><td style=\"padding:0;\">{$createdAt->format('d/m/Y à\\s H:i')}</td></tr>
            </table>
        ";
    }

    protected function to(): array
    {
        return self::DIGITAL_ORDER_RECIPIENTS;
    }
}
