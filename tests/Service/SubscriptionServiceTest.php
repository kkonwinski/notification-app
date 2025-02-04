<?php

namespace App\Tests\Service;

use App\Service\SubscriptionService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\KernelInterface;

class SubscriptionServiceTest extends TestCase
{
    private string $tempDir;
    private SubscriptionService $subscriptionService;

    protected function setUp(): void
    {
        $this->tempDir = sys_get_temp_dir() . '/sub_test_' . uniqid();

        if (!is_dir($this->tempDir)) {
            mkdir($this->tempDir, 0777, true);
        }

        mkdir($this->tempDir . '/var', 0777, true);

        $kernel = $this->createMock(KernelInterface::class);
        $kernel->method('getProjectDir')
            ->willReturn($this->tempDir);

        $this->subscriptionService = new SubscriptionService($kernel);
    }


    protected function tearDown(): void
    {
        if (is_dir($this->tempDir)) {
            $this->deleteDirectory($this->tempDir);
        }
    }

    public function testDefaultSubscriptionStatus(): void
    {
        $status = $this->subscriptionService->getSubscriptionStatus(123);
        $this->assertFalse($status['email']);
        $this->assertFalse($status['sms']);
    }

    public function testSetSubscription(): void
    {
        $this->subscriptionService->setSubscription(123, 'email', true);
        $this->subscriptionService->setSubscription(123, 'sms', false);

        $status = $this->subscriptionService->getSubscriptionStatus(123);
        $this->assertTrue($status['email']);
        $this->assertFalse($status['sms']);
    }

    private function deleteDirectory(string $dir): void
    {
        if (!file_exists($dir)) {
            return;
        }
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $path = $dir . DIRECTORY_SEPARATOR . $file;
                if (is_dir($path)) {
                    $this->deleteDirectory($path);
                } else {
                    unlink($path);
                }
            }
        }
        rmdir($dir);
    }
}
