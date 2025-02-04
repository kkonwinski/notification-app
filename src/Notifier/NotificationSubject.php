<?php

namespace App\Notifier;

class NotificationSubject
{
    /** @var ObserverInterface[] */
    private array $observers = [];

    public function attach(ObserverInterface $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(ObserverInterface $observer): void
    {
        $this->observers = array_filter($this->observers, fn($o) => $o !== $observer);
    }

    public function notifyAll(string $message): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($message);
        }
    }
}
