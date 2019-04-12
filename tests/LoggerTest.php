<?php

use PHPUnit\Framework\TestCase;
use AdminPanel\Cache\FileCache;
use AdminPanel\Logger\Logger;

final class LoggerTest extends TestCase
{
    public function testCanLog()
    {
        $file = "tests/logs.log";
        $logger = new Logger($file);
        $this->assertFileExists($file);

        $logger->info("test");
        $this->assertStringEqualsFile(
            $file,
            "[Info]: " . (new \DateTime())->format("Y-m-d H:i:s") . " test\n"
        );
        unlink($file);
    }
}
