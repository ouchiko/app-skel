<?php
namespace trains\models\store;
/**
 * Storage Module for System. Implements Stash (Memcached)
 */
use Stash\Driver\Memcache;
use Stash\Pool;

class MemCacher {
    /**
     * Construct and define server and port number
     * 
     * @param <string> server_name
     * @param <int> port
     */
    public function __construct($server_name, $port = 11211) {
        $this->driver = new Memcache(["servers"=>[$server_name, $port]]);
        $this->pool = new Pool($this->driver);
    }

    /**
     * Saves a new item of data
     * 
     * @param <string> key
     * @param <string> value
     * @param <int> expires
     */
    public function save($key, $value, $expires = 3600) {
        $item = $this->pool->getItem(base64_encode($key));
        $item->set($value);
        $item->expiresAfter($expires);
        $this->pool->save($item);
    }

    /**
     * When does the item expire
     * 
     * @param <string> key
     * 
     * @return <Datetime>
     */
    public function expires($key) {
        $item = $this->pool->getItem(base64_encode($key));
        return $item->getExpiration();
    }

    /**
     * Gets a cached key
     * 
     * @param <string> key
     * 
     * @return <mixed>
     */
    public function get($key) {
        $item = $this->pool->getItem(base64_encode($key));
        if ($item->isMiss()) {
            $item->clear();
            return false;
        } else {
            return [
                "key" => $key,
                "id" => base64_encode($key),
                "value" => $item->get()
            ];
        }
    }

    /**
     * Clears an item
     * 
     * @param <string> key
     */
    public function clear($key) {
        $item = $this->pool->getItem(base64_encode($key));
        $item->clear();
    }
}