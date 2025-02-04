<?php

namespace App\Service;

use Symfony\Component\HttpKernel\KernelInterface;

class SubscriptionService
{
    private string $filePath;

    public function __construct(KernelInterface $kernel)
    {
        $this->filePath = $kernel->getProjectDir().'/var/subscriptions.json';
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
    }

    private function loadData(): array
    {
        return json_decode(file_get_contents($this->filePath), true) ?: [];
    }

    private function saveData(array $data): void
    {
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function getSubscriptionStatus(int $personId): array
    {
        $data = $this->loadData();
        return $data[$personId] ?? ['email' => false, 'sms' => false];
    }

    public function setSubscription(int $personId, string $type, bool $value): void
    {
        $data = $this->loadData();
        if (!isset($data[$personId])) {
            $data[$personId] = ['email' => false, 'sms' => false];
        }
        if (in_array($type, ['email', 'sms'])) {
            $data[$personId][$type] = $value;
        }
        $this->saveData($data);
    }
}
