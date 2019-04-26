<?php

namespace DeltaCMS\Cache;

use Psr\SimpleCache\CacheInterface;

abstract class AbstractCache implements CacheInterface
{
    public function getMultiple($keys, $default = null)
    {
        if (!is_iterable($keys)) {
            throw new InvalidArgumentException('Keys are not iterable');
        }
        $result = array();
        foreach ($keys as $key) {
            if (!$this->checkKey($key)) {
                throw new InvalidArgumentException("Invalid Key");
            }
            $result[$key] = $this->get($key, $default);
        }
        return $result;
    }

    public function setMultiple($values, $ttl = null)
    {
        if (!is_iterable($values)) {
            throw new InvalidArgumentException('Values are not Iterable');
        }
        foreach ($values as $key => $value) {
            if (!$this->checkKey($key)) {
                throw new InvalidArgumentException("Invalid Key");
            }
            $tmp = $this->set($key, $value, $ttl);
            if (!$tmp) {
                return false;
            }
        }
        return true;
    }

    public function deleteMultiple($keys)
    {
        if (!is_iterable($keys)) {
            throw new InvalidArgumentException('Keys are not iterable');
        }
        foreach ($keys as $key) {
            if (!$this->checkKey($key)) {
                throw new InvalidArgumentException("Invalid Key");
            }
            $tmp = $this->delete($key);
            if (!$tmp) {
                return false;
            }
        }
        return true;
    }



    protected function checkKey($key)
    {
        return preg_match('/^[A-Za-z0-9_.]{1,64}$/', $key);
    }

    /**
     * return the time to live
     *
     * @param int|\DateInterval $ttl
     *
     * @return int
     */
    protected function getTTL($ttl): int
    {
        if (is_int($ttl)) {
            return $ttl;
        } else {
            return
                ((($ttl->y * 365 + $ttl->m * 30 + $ttl->d //translate to days
                ) * 24 + $ttl->h //translate to hours
                ) * 60 + $ttl->i //translate to minutes
                ) * 60 + $ttl->s //translate to seconds
            ;
        }
    }
}
