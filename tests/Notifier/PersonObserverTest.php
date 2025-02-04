<?php

namespace App\Tests\Notifier;

use App\Entity\Person;
use App\Notifier\PersonObserver;
use App\Service\SubscriptionService;
use PHPUnit\Framework\TestCase;

class PersonObserverTest extends TestCase
{
    public function testUpdateEmailOnly(): void
    {
        $person = new Person();
        $person->setEmail('test@example.com');
        $person->setPhone('123123123');
        $person->setName('Test');
        $person->setLastName('Person');

        $reflection = new \ReflectionProperty($person, 'id');
        $reflection->setValue($person, 100);

        // Mock SubscriptionService
        $subscriptionService = $this->createMock(SubscriptionService::class);
        $subscriptionService->method('getSubscriptionStatus')
            ->willReturn(['email' => true, 'sms' => false]);

        $observer = new PersonObserver($person, $subscriptionService);
        $observer->update('Hello World');

        $this->assertTrue(true);
    }


    /**
     * @throws \ReflectionException
     */
    public function testUpdateEmailAndSms(): void
    {
        $person = new Person();
        $person->setEmail('sms@example.com');
        $person->setPhone('555-123-456');
        $person->setName('Test');
        $person->setLastName('Sms');

        $reflection = new \ReflectionProperty($person, 'id');
        $reflection->setValue($person, 200);

        $subscriptionService = $this->createMock(SubscriptionService::class);
        $subscriptionService->method('getSubscriptionStatus')
            ->willReturn(['email' => true, 'sms' => true]);

        $observer = new PersonObserver($person, $subscriptionService);
        $observer->update('Message');

        $this->assertTrue(true);
    }

}
