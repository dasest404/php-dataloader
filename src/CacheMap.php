<?php

namespace leinonen\DataLoader;

class CacheMap implements CacheMapInterface, \Countable
{
    /**
     * @var array
     */
    private $cache = [];

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        $index = $this->findCacheIndexByKey($key);

        if ($index === null) {
            return false;
        }

        return $this->cache[$index]['value'];
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $cacheEntry = [
            'key' => $key,
            'value' => $value,
        ];
        $index = $this->findCacheIndexByKey($key);

        if ($index !== null) {
            $this->cache[$index] = $cacheEntry;

            return;
        }

        $this->cache[] = $cacheEntry;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($key)
    {
        $index = $this->findCacheIndexByKey($key);
        unset($this->cache[$index]);
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->cache = [];
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return \count($this->cache);
    }

    /**
     * Returns the index of the value from the cache array with the given key.
     *
     * @param mixed $cacheKey
     *
     * @return mixed
     */
    private function findCacheIndexByKey($cacheKey)
    {
        foreach ($this->cache as $index => $data) {
            if ($data['key'] === $cacheKey) {
                return $index;
            }
        }
    }
}
