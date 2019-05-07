<?php

namespace DeltaCMS\Route;

use DeltaCMS\Route\RouteInterface;
use DeltaCMS\DeltaCMS;

class Router
{
    private $cache;
    private $cacheName = "routes";
    private $ttl = 9999999;

    /*
    Elements:
    c = Controller
    fu = Function
    o = Options
    fi = file
    */

    public function __construct()
    {
        $this->cache = DeltaCMS::getInstance()->getCache();
        $this->cache->set($this->cacheName, array(), $this->ttl);
    }

    public function getRoutes(): array
    {
        return $this->cache->get($this->cacheName, array());
    }

    public function setRoute(RouteInterface $route)
    {
        $this->cache->set(
            $this->cacheName,
            array_merge(
                $this->cache->get($this->cacheName),
                array(
                    $route->getName() => $route
                )
            ),
            $this->ttl
        );
    }

    public function renderRouteByUri(string $uri)
    {
        $contains = strstr($uri, "?", true);
        if ($contains !== false) {
            $uri = $contains;
        }
        foreach ($this->getRoutes() as /*$routeName =>*/ $route) {
            // dump($routeName);
            $slug = $route->getPath();
            $options = $route->getOptions();
            $res = $this->isSlugEqualToUri($slug, $uri, $options);
            if ($res !== false) {
                // dump($route);
                return $route->render($res);
            }
        }
    }

    /**
     * check if a Slug containing `{var}` is equal to an URI
     *
     * @param string $slug
     * @param string $uri
     * @param array $options
     *
     * @return boolean|array
     */
    public function isSlugEqualToUri(string $slug, string $uri, array $options)
    {
        $uri = trim($uri, "\/");
        $slug = trim($slug, "\/");
        $splittedSlug = explode("{", $slug);

        if (count($splittedSlug) === 1) {
            return $uri === $slug ? array() : false;
        }

        return $this->processSlug($uri, $splittedSlug, $options);
    }

    private function processSlug($uri, $splittedSlug, $options)
    {
        $precedentContent = "";
        $urlVars = array();
        foreach ($splittedSlug as $value) {
            // dump($value, $uri);
            if (startsWith($uri, $value)) {
                $precedentContent .= $value;
                continue;
            }
            $splittedValue = explode("}", $value);
            if (count($splittedValue) == 1) {
                return false;
            }
            $key = $splittedValue[0];
            $afterContent = $splittedValue[1];

            $regex = isset($options["args"][$key]["regex"]) ? $options["args"][$key]["regex"] : null;

            $val = $this->getVal($precedentContent, $uri, $afterContent);
            if ($val !== false && isset($regex) && preg_match("/" . $regex . "/", $val)) {
                $urlVars[$key] = $val;
                $precedentContent .= $val . $afterContent;
                continue;
            }
            return false;
        }
        return $urlVars;
    }

    public function getVal(string $precedentContent, string $uri, string $afterContent)
    {
        if (strpos($uri, $precedentContent) !== false &&
            ($afterContent === '' || strpos($uri, $afterContent) !== false)
        ) {
            $precedentContent = "/" . str_replace("/", "\/", $precedentContent) . "/";
            // $afterContent = "/" . str_replace("/", "\/", $afterContent) . "/";
            $content = preg_filter($precedentContent, "", $uri, 1);
            if ($afterContent === '') {
                return $content;
            }
            $arr = explode($afterContent, $content);
            if ($arr !== false && isset($arr[0])) {
                return $arr[0];
            }
        }
    }
}

/*
paths examples
- /test
- /test/{test}
- /test/test-{test}
- /test-{test1}-{test2}

not compatible right now
- /test{test1}{test2}
*/
