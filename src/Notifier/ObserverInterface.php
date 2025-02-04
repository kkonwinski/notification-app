<?php

namespace App\Notifier;

interface ObserverInterface
{
    public function update(string $message): void;
}
