<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use DeltaCMS\Logger;
use Psr\Log\InvalidArgumentException;
use Exception;
use DeltaCMS\Exception\FileException;

final class LoggerTest extends TestCase
{
    private $file;
    private $logger;

    public function __construct()
    {
        parent::__construct();
        $file = "tests/logs.log";
        if (file_exists($file)) {
            unlink($file);
        }
        $this->file = $file;
        $this->logger = new Logger($file);
    }

    public function testFileIsCreated()
    {
        unlink($this->file);
        new Logger($this->file);
        $this->assertFileExists($this->file);
    }

    public function testCanLog()
    {
        $logger = $this->logger;

        $exception = new Exception("hello phpunit");
        $logger->alert("test", array(
            'exception' => $exception
        ));
        $this->assertStringEqualsFile(
            $this->file,
            "[Alert]: " .
            (new \DateTime())->format("Y-m-d H:i:s") .
            " test\n[Alert]: " .
            (new \DateTime())->format("Y-m-d H:i:s") .
            " 0 " .
            $exception->getFile() .
            "[Exception] 0 " .
            $exception->getMessage() .
            "\n"
        );
    }


    public function testFileException()
    {
        $file = "tests/this-folder-don't & can't exist/logs.log";
        $this->expectException(FileException::class);
        new Logger($file);
    }

    public function testLevelException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->logger->log('incorrect_level', "level incorrect");
    }

    public function testArgumentsException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->logger->log("info");
    }
}
