<?php

namespace Samchentw\Common\Objects;

use ArrayAccess;
use ArrayIterator;
use Exception;
use Samchentw\Common\Helpers\DictionaryHelper;

class Dictionary implements ArrayAccess
{
    /**
     * @var array
     */
    protected $items = [];

    public function __construct(array $array, string $keyColumn, $valueColumn = null)
    {
        $this->items = DictionaryHelper::toDictionary($array, $keyColumn, $valueColumn);
    }

    public function all()
    {
        if (is_array($this->items)) {
            return $this->items;
        }

        return iterator_to_array($this->getIterator());
    }

    public function getByKey($key)
    {
        if (!$this->hasKey($key)) return null;
        return $this->items[$key];
    }

    public function hasKey($key)
    {
        return array_key_exists($key, $this->items);
    }


    /**
     * Remove an item from the collection by key.
     *
     * @param  string|array  $keys
     * @return $this
     */
    public function forget($keys)
    {
        foreach ((array) $keys as $key) {
            $this->offsetUnset($key);
        }

        return $this;
    }

    /**
     * Push one or more items onto the end of the collection.
     *
     * @param  mixed  $values [optional]
     * @return $this
     */
    public function push($key, $value)
    {
        if ($this->hasKey($key)) {
            throw new Exception('items Has Already $key');
        }

        $this->items[$key] = $value;
        return $this;
    }

    public function put($key, $value)
    {
        $this->items[$key] = $value;
        return $this;
    }


    /**
     * Get an iterator for the items.
     *
     * @return \ArrayIterator
     */
    #[\ReturnTypeWillChange]
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Count the number of items in the collection.
     *
     * @return int
     */
    #[\ReturnTypeWillChange]
    public function count()
    {
        return count($this->items);
    }


    /**
     * Determine if an item exists at an offset.
     *
     * @param  mixed  $key
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($key)
    {
        return isset($this->items[$key]);
    }

    /**
     * Get an item at a given offset.
     *
     * @param  mixed  $key
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    /**
     * Set the item at a given offset.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }
}
