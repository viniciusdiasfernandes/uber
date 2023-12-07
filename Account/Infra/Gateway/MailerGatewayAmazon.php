<?php

namespace Account\Infra\Gateway;

use Account\Gateway\MailerGateway;

class MailerGatewayAmazon implements MailerGateway
{

    public function send(string $email, string $subject, string $message): string
    {
        return $message;
    }
}