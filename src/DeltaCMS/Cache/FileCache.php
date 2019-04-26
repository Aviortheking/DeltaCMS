<?php

namespace DeltaCMS\Cache;

use Exception;

class FileCache extends AbstractCache
{
    private $folder;
    private $ttl;

    /**
     * Cache Constructor
     *
     * @param object $options
     */
    public function __construct(object $options)
    {
        $this->folder = isset($options->path) ? $options->path . "/" . "fs/" : "./cache";
        // dd($this->folder);
        $this->ttl = $this->getTTL(isset($options->ttl) ? $options->ttl : 86400);
        if (!file_exists($this->folder)) {
            mkdir($this->folder, 0777, true);
        }
    }

    public function get($key, $default = null)
    {
        if (!$this->checkKey($key)) {
            throw new InvalidArgumentException("key is not correct");
        }
        $file = $this->folder . DIRECTORY_SEPARATOR . $key;
        if (is_file($file)) {
            $content = file_get_contents($file);
            if ($content !== false) {
                $res = unserialize($content);
                if ($res["ttl"] > time() && $res['value'] !== null) {
                    return $res["value"];
                } else {
                    $this->delete($key);
                }
            } else {
                throw new Exception("Cache file couldn't be read", 1);
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
        $files = scandir($this->folder);
        if ($files === false) {
            throw new Exception("couldn't clear cache, the folder seems unreadable", 1);
        }
        $keys = array_diff($files, array("..", "."));
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }

    public function has($key)
    {
        return is_file($this->folder . DIRECTORY_SEPARATOR . $key);
    }
}
