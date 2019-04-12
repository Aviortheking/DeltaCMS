<?php

namespace AdminPanel\Cache;

use Psr\SimpleCache\CacheInterface;

class FileCache implements CacheInterface
{
    private $folder;
    private $ttl;

    private function checkKey($key)
    {
        return preg_match('/^[A-Za-z0-9_.]{1,64}$/', $key);
    }

    private function getTTL($ttl)
    {
        if (is_int($ttl)) {
            return $ttl;
        } else {
            return
                ((($ttl->y * 365 + $ttl->m * 30 + $ttl->d
                ) * 24 + $ttl->h
                ) * 60 + $ttl->i
                ) * 60 + $ttl->s;
        }
    }

    /**
     * Cache Constructor
     *
     * @param string $folder
     * @param integer|\DateInterval $ttl
     */
    public function __construct(string $folder = "./cache", $ttl = 86400)
    {
        $this->folder = $folder;
        if (!file_exists($this->folder)) {
            mkdir($this->folder, 0777, true);
        }
        $this->ttl = $this->getTTl($ttl);
    }

    public function get($key, $default = null)
    {
        if (!$this->checkKey($key)) {
            throw new InvalidArgumentException("key is not correct");
        }
        $file = $this->folder . DIRECTORY_SEPARATOR . $key;
        if (is_file($file)) {
            $res = unserialize(file_get_contents($file));
            if ($res["ttl"] > time() && $res['value'] !== null) {
                return $res["value"];
            } else {
                $this->delete($key);
            }
        }
        return $default;
    }

    public function set($key, $value, $ttl = null)
    {
        if (!$this->checkKey($key)) {
            throw new InvalidArgumentException("key is not valid");
        }
        $tl = $ttl != null ? $this->getTTL($ttl) : $this->ttl;
        $arr = array(
            "value" => $value,
            'ttl' => time() + $tl
        );
        return file_put_contents($this->folder . DIRECTORY_SEPARATOR . $key, serialize($arr)) ? true : false;
    }

    public function delete($key)
    {
        if (!$this->checkKey($key)) {
            throw new InvalidArgumentException("key is not valid");
        }
        return unlink($this->folder . DIRECTORY_SEPARATOR . $key);
    }

    public function clear()
    {
        $keys = array_diff(scandir($this->folder), array("..", "."));
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }

    public function getMultiple($keys, $default = null)
    {
        if (!is_iterable($keys)) {
            throw new InvalidArgumentException('$keys isn\'t traversable');
        }
        $result = array();
        foreach ($keys as $key) {
            if (!$this->checkKey($key)) {
                throw new InvalidArgumentException("a key in the array is invalid");
            }
            $result[$key] = $this->get($key, $default);
        }
        return $result;
    }

    public function setMultiple($values, $ttl = null)
    {
        if (!is_iterable($values)) {
            throw new InvalidArgumentException('$values isn\'t traversable');
        }
        foreach ($values as $key => $value) {
            $tmp = $this->set($key, $value, $ttl);
            if (!$tmp) {
                return false;
            }
        }
        return true;
    }

    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }

    public function has($key)
    {
        return is_file($this->folder . DIRECTORY_SEPARATOR . $key);
    }
}
