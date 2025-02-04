<?php

namespace App\Notifier;

use App\Entity\Person;

class EmailNotifierAdapter implements NotifierInterface
{
    public function notify(Person $person, string $message): void
    {
        // $email = (new Email())
        //     ->from('no-reply@mojadomena.com')
        //     ->to($person->getEmail())
        //     ->subject('Powiadomienie')
        //     ->text($message);
        //
        // $this->mailer->send($email);

        // echo "Wysłano email do: {$person->getEmail()} z treścią: $message";
    }
}
