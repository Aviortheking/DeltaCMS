<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use DeltaCMS\Cache\SessionCache;

final class SessionCacheTest extends TestCase
{

    private $session;

    public function __construct()
    {
        parent::__construct();
        $this->session = new SessionCache();
    }

    public function testCacheCanStart()
    {
        $this->assertEquals(
            session_status(),
            PHP_SESSION_ACTIVE
        );
    }

    public function testCanSet()
    {

        $this->assertEquals(
            true,
            $this->session->set("key", "value")
        );
    }

    public function testCanGet()
    {
        $this->assertTrue(
            $this->session->set("key", "value")
        );
        $this->assertEquals(
            'value',
            $this->session->get('key')
        );
    }


    public function testCanDelete()
    {
        $this->assertTrue(
            $this->session->set("key", "value")
        );
        $this->assertTrue(
            $this->session->delete('key')
        );
        $this->assertNull(
            $this->session->get('key')
        );
    }

    public function testCanSetGetMultiple()
    {

        $this->assertTrue(
            $this->session->setMultiple(array(
                "key1" => "value",
                "key2" => "value"
            ))
        );

        $result = $this->session->getMultiple(array(
            "key1",
            "key2"
        ));
        $this->assertEquals(
            "value",
            $result["key1"]
        );
        $this->assertEquals(
            "value",
            $result["key2"]
        );

        $this->assertTrue(
            $this->session->deleteMultiple(array(
                "key1",
                "key2"
            ))
        );
    }
}
