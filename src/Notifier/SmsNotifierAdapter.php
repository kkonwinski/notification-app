<?php

namespace App\Notifier;

use App\Entity\Person;

class SmsNotifierAdapter implements NotifierInterface
{
    public function notify(Person $person, string $message): void
    {
           // echo "Wysłano SMS na numer: {$person->getPhone()} z treścią: $message";
    }
}
