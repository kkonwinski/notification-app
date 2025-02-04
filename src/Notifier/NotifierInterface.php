<?php

namespace App\Notifier;

use App\Entity\Person;

interface NotifierInterface
{
    public function notify(Person $person, string $message): void;
}
