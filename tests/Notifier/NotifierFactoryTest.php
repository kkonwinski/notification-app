<?php

namespace App\Tests\Notifier;

use App\Notifier\EmailNotifierAdapter;
use App\Notifier\NotifierFactory;
use App\Notifier\NotifierInterface;
use App\Notifier\SmsNotifierAdapter;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class NotifierFactoryTest extends TestCase
{
    public function testCreateEmailNotifier(): void
    {
        $notifier = NotifierFactory::createNotifier('email');
        $this->assertInstanceOf(EmailNotifierAdapter::class, $notifier);
        $this->assertInstanceOf(NotifierInterface::class, $notifier);
    }

    public function testCreateSmsNotifier(): void
    {
        $notifier = NotifierFactory::createNotifier('sms');
        $this->assertInstanceOf(SmsNotifierAdapter::class, $notifier);
        $this->assertInstanceOf(NotifierInterface::class, $notifier);
    }

    public function testUnsupportedNotifierType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        NotifierFactory::createNotifier('unsupported');
    }
}
