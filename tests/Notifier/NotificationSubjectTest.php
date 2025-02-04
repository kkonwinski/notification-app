<?php

namespace App\Tests\Notifier;

use App\Notifier\NotificationSubject;
use App\Notifier\ObserverInterface;
use PHPUnit\Framework\TestCase;

class NotificationSubjectTest extends TestCase
{
    public function testAttachAndNotifyAll(): void
    {
        $subject = new NotificationSubject();

        $observer1 = $this->createMock(ObserverInterface::class);
        $observer2 = $this->createMock(ObserverInterface::class);

        $observer1->expects($this->once())
            ->method('update')
            ->with('Hello');

        $observer2->expects($this->once())
            ->method('update')
            ->with('Hello');

        $subject->attach($observer1);
        $subject->attach($observer2);

        $subject->notifyAll('Hello');
    }

    public function testDetach(): void
    {
        $subject = new NotificationSubject();

        $observer1 = $this->createMock(ObserverInterface::class);
        $observer2 = $this->createMock(ObserverInterface::class);

        $observer1->expects($this->once())
            ->method('update')
            ->with('Test');

        $observer2->expects($this->never())
            ->method('update');

        $subject->attach($observer1);
        $subject->attach($observer2);
        $subject->detach($observer2);

        $subject->notifyAll('Test');
    }
}
