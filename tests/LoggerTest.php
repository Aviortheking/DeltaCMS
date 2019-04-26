<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use DeltaCMS\Cache\FileCache;
use DeltaCMS\Logger;
use Psr\Log\InvalidArgumentException;
use Exception;

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

        $exception = new Exception("hello phpunit");
        $logger->alert("test", array(
            'exception' => $exception
        ));
        $this->assertStringEqualsFile(
            $file,
            "[Alert]: " . (new \DateTime())->format("Y-m-d H:i:s") . " test\n[Alert]: " . (new \DateTime())->format("Y-m-d H:i:s") . " 0 " . $exception->getFile() . "[Exception] 0 " . $exception->getMessage() . "\n"
        );
    }

    public function testLevelException()
    {
        $file = "tests/logs.log";
        if (file_exists($file)) {
            unlink($file);
        }
        $logger = new Logger($file);
        try {
            $logger->log('incorrect_level', "level incorrect");
        } catch (InvalidArgumentException $e) {
            $this->assertEquals($e->getMessage(), "Level not supported");
            return;
        }
        $this->fail();
    }

    public function testNothingException()
    {
        $file = "tests/logs.log";
        if (file_exists($file)) {
            unlink($file);
        }
        $logger = new Logger($file);
        try {
            $logger->log("info");
        } catch (InvalidArgumentException $e) {
            $this->assertEquals($e->getMessage(), "Message and Exception not set");
            return;
        }
        $this->fail();
    }
}
