<?php
namespace Core\Storage;

/**
 * AbstractStorage.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016-2017
 * @license MIT
 */
abstract class AbstractStorage implements StorageInterface, \ArrayAccess, \IteratorAggregate
{

    /**
     *
     * @var array
     */
    protected $data = [];

    /**
     *
     * {@inheritdoc}
     * @see \Core\Storage\AbstractStorage::getValue()
     */
    public function getValue(string $key)
    {
        if (! isset($this->data[$key])) {
            $this->data[$key] = new self();
        }
        
        return $this->data[$key];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Storage\StorageInterface::setValue()
     */
    public function setValue(string $key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Storage\StorageInterface::get()
     */
    public function get(string $key)
    {
        return $this->getValue($key);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Storage\StorageInterface::set()
     */
    public function set(string $key, $value)
    {
        $this->setValue($key, $value);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Storage\StorageInterface::__get()
     */
    public function __get($key)
    {
        return $this->getValue($key);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Storage\StorageInterface::__set()
     */
    public function __set($key, $value)
    {
        $this->setValue($key, $value);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Storage\StorageInterface::exists()
     */
    public function exists($key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Storage\StorageInterface::__isset()
     */
    public function __isset($offset)
    {
        return $this->exists($offset);
    }

    /**
     *
     * {@inheritdoc}
     * @see \ArrayAccess::offsetExists()
     */
    public function offsetExists($offset)
    {
        return $this->exists($offset);
    }

    /**
     *
     * {@inheritdoc}
     * @see \ArrayAccess::offsetGet()
     */
    public function offsetGet($offset)
    {
        return $this->getValue($offset);
    }

    /**
     *
     * {@inheritdoc}
     * @see \ArrayAccess::offsetSet()
     */
    public function offsetSet($offset, $value)
    {
        $this->setValue($offset, $value);
    }

    /**
     *
     * {@inheritdoc}
     * @see \ArrayAccess::offsetUnset()
     */
    public function offsetUnset($offset)
    {
        if ($this->exists($offset)) {
            unset($this->data[$offset]);
        }
    }

    /**
     *
     * {@inheritdoc}
     * @see \IteratorAggregate::getIterator()
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }
}

