<?php

use PHPUnit\Framework\TestCase;
use AdminPanel\Cache\FileCache;
use AdminPanel\Logger;

final class LoggerTest extends TestCase
{
    public function testCanLog()
    {
        $file = "tests/logs.log";
        if (file_exists($file)) {
            unlink($file);
        }
        $logger = new Logger($file);
        $this->assertFileExists($file);

        $logger->info("test");
        $this->assertStringEqualsFile(
            $file,
            "[Info]: " . (new \DateTime())->format("Y-m-d H:i:s") . " test\n"
        );
    }

    public function testCanLogExceptions()
    {
        $file = "tests/logs.log";
        if (file_exists($file)) {
            unlink($file);
        }
        $logger = new Logger($file);
        $this->assertFileExists($file);

        $exception = new Exception("hello phpunit");
        $logger->alert("test", array(
            'exception' => $exception
        ));
        $this->assertStringEqualsFile(
            $file,
            "[Alert]: " . (new \DateTime())->format("Y-m-d H:i:s") . " test\n[Alert]: " . (new \DateTime())->format("Y-m-d H:i:s") . " 0 " . $exception->getFile() . "[Exception] 0 " . $exception->getMessage() . "\n"
        );
    }
}
