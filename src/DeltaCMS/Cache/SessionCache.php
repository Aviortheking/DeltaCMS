<?php

namespace DeltaCMS\Cache;

/**
 * Session Cache (different type of cache because is per-user cache)
 * ttl can be overriden by cookie clearing
 *
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class SessionCache extends AbstractCache
{
    private $ttl = 86400;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function get($key, $default = null)
    {
        if (!$this->checkKey($key)) {
            throw new InvalidArgumentException("Invalid Key");
        }
        if (isset($_SESSION[$key])) {
            $item = $_SESSION[$key];
            if ($item["ttl"] > time() && $item["value"] !== null) {
                return $item["value"];
            } else {
                $this->delete($key);
            }
        }
        return $default;
    }

    public function set($key, $value, $ttl = null)
    {
        if (!$this->checkKey($key)) {
            throw new InvalidArgumentException("Invalid Key");
        }
        $_SESSION[$key] = array(
            "value" => $value,
            "ttl" => time() + ($ttl !== null ? $this->getTTL($ttl) : $this->ttl)
        );
        return true;
    }

    public function delete($key)
    {
        if (!$this->checkKey($key)) {
            throw new InvalidArgumentException("Invalid Key");
        }
        $_SESSION[$key] = null;
        return true;
    }

    public function clear()
    {
        if (phpversion() !== false && version_compare(phpversion(), '7.2.0', '<')) {
            return session_reset();
        }
        session_reset();
        return true;
    }

    public function has($key)
    {
        if (!$this->checkKey($key)) {
            throw new InvalidArgumentException("Invalid Key");
        }
        return isset($_SESSION[$key]) && !empty($_SESSION[$key]);
    }
}
