<?php

namespace App\Notifier;

use App\Entity\Person;
use App\Service\SubscriptionService;

class PersonObserver implements ObserverInterface
{
    public function __construct(
        private Person $person,
        private SubscriptionService $subscriptionService
    ) {
    }

    public function update(string $message): void
    {
        $subscription = $this->subscriptionService->getSubscriptionStatus($this->person->getId());
        if ($subscription['email'] === true) {
            $notifier = NotifierFactory::createNotifier('email');
            $notifier->notify($this->person, $message);
        }
        if ($subscription['sms'] === true) {
            $notifier = NotifierFactory::createNotifier('sms');
            $notifier->notify($this->person, $message);
        }
    }
}
