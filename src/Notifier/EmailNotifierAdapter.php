<?php

namespace App\Notifier;

use App\Entity\Person;

class EmailNotifierAdapter implements NotifierInterface
{
    public function notify(Person $person, string $message): void
    {
        // Tutaj mogłaby być logika używająca np. MailerInterface (Symfony Mailer),
        // SwiftMailer lub innej biblioteki do wysyłki email.

        // Przykład (hipotetyczny):
        // $email = (new Email())
        //     ->from('no-reply@mojadomena.com')
        //     ->to($person->getEmail())
        //     ->subject('Powiadomienie')
        //     ->text($message);
        //
        // $this->mailer->send($email);

        // Na potrzeby przykładu wystarczy komentarz:
        // echo "Wysłano email do: {$person->getEmail()} z treścią: $message";
    }
}
