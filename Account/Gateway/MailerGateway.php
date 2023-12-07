<?php

namespace Account\Gateway;

interface MailerGateway
{
    public function send(string $email, string $subject, string $message): string;
}