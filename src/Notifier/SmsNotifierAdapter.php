<?php

namespace App\Notifier;

use App\Entity\Person;

class SmsNotifierAdapter implements NotifierInterface
{
    public function notify(Person $person, string $message): void
    {
        // Tutaj logika używająca API do wysyłki SMS
        // np. Twilio, SMSAPI lub innego dostawcy.

        // echo "Wysłano SMS na numer: {$person->getPhone()} z treścią: $message";
    }
}
