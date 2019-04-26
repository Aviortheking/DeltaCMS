<?php

namespace Tests\Cache;

use PHPUnit\Framework\TestCase;
use DeltaCMS\Cache\SessionCache;
use DeltaCMS\Cache\InvalidArgumentException;

use DateInterval;

final class SessionCacheTest extends TestCase
{

    private $session;

    public function __construct()
    {
        $this->session = new SessionCache();
        parent::__construct();
    }

    public function testCacheHasStarted()
    {
        $this->assertEquals(
            session_status(),
            PHP_SESSION_ACTIVE
        );
    }

    public function testCanSetAndGet()
    {
        $this;
        $value = "value";
        $this->assertTrue(
            $this->session->set("key", $value)
        );

        $this->assertEquals(
            $value,
            $this->session->get("key")
        );
    }

    public function testCanGetDefaultIfTTL()
    {
        $this->session->set("ttling", "yes of course", 0);

        $this->assertFalse(
            $this->session->get("ttling", false)
        );

        $this->session->set("ttling", "yes of course", DateInterval::createFromDateString("2019-02-10"));

        $this->assertFalse(
            $this->session->get("ttling", false)
        );
    }

    public function testCanGetDefaultIfNotSet()
    {
        $values = array(
            'test',
            true,
            1,
            array()
        );
        foreach ($values as $value) {
            $this->assertEquals(
                $value,
                $this->session->get("random_be_with_me", $value)
            );
        }
    }


    public function testCanDelete()
    {
        $this->session->set("key", "value");
        $this->assertTrue(
            $this->session->delete('key')
        );
        $this->assertNull(
            $this->session->get('key')
        );
    }

    public function testCanClearCache()
    {
        $array = array(
            "key1" => "value",
            "key2" => true,
            "key3" => 1
        );
        $this->assertTrue(
            $this->session->setMultiple($array)
        );
        $this->assertTrue(
            $this->session->clear()
        );
        $this->assertContainsOnly(
            "string",
            $this->session->getMultiple(array_keys($array), "default")
        );
    }

    public function testHas()
    {
        $this->assertFalse(
            $this->session->has("pokemon")
        );

        $this->session->set("pokemon", "go");

        $this->assertTrue(
            $this->session->has("pokemon")
        );
    }




    /**
     * Exceptions :p
     */

    public function testInvalidKeySet()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->session->set("I have some spaces!", "I am a value");
    }

    public function testInvalidKeyGet()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->session->get("I have some spaces!", "I am a value");
    }

    public function testInvalidKeyDelete()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->session->delete("I have some spaces!", "I am a value");
    }

    public function testInvalidKeyHas()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->session->has("I have some spaces!", "I am a value");
    }
}
