<?php

namespace App\Notifier;

class NotifierFactory
{
    public static function createNotifier(string $type): NotifierInterface
    {
        return match ($type) {
            'email' => new EmailNotifierAdapter(),
            'sms' => new SmsNotifierAdapter(),
            default => throw new \InvalidArgumentException("Unsupported type $type."),
        };
    }
}
