<?php

namespace Tests\Cache;

use PHPUnit\Framework\TestCase;
use DeltaCMS\Cache\SessionCache;
use DeltaCMS\Cache\InvalidArgumentException;

class AbstractCacheTest extends TestCase
{
    private $session;

    public function __construct()
    {
        $this->session = new SessionCache();
        parent::__construct();
    }

    public function testCanSetGetDeleteMultiple()
    {
        $array = array(
            "key1" => "value",
            "key2" => true,
            "key3" => 1
        );
        $this->assertTrue(
            $this->session->setMultiple($array)
        );

        $this->assertEquals(
            $array,
            $this->session->getMultiple(array_keys($array))
        );

        $this->assertTrue(
            $this->session->deleteMultiple(array_keys($array))
        );

        $this->assertContainsOnly(
            "string",
            $this->session->getMultiple(array_keys($array), "default")
        );
    }


    /**
     * Exceptions :p
     */

    public function testGetMultipleIterable()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Keys are not iterable');
        $this->session->getMultiple("I have some spaces!", "I am a value");
    }

    public function testSetMultipleIterable()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Values are not Iterable');
        $this->session->setMultiple("I have some spaces!", "I am a value");
    }

    public function testDeleteMultipleIterable()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Keys are not iterable');
        $this->session->deleteMultiple("I have some spaces!", "I am a value");
    }

    public function testGetMultipleInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Key');
        $this->session->getMultiple(array("I have some spaces!"), "I am a value");
    }

    public function testSetMultipleInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Key');
        $this->session->setMultiple(array("I have some spaces!" => "test"));
    }

    public function testDeleteMultipleInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Key');
        $this->session->deleteMultiple(array("I have some spaces!"));
    }
}
