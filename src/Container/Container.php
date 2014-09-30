<?php

namespace frostealth\Container;

use frostealth\Storage\Data;

/**
 * Class Container
 *
 * @package frostealth\Container
 */
class Container
{
    /** @var Data */
    protected $storage;

    public function __construct()
    {
        $this->storage = new Data();
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function get($name)
    {
        $value = $this->storage->get($name);
        if (is_callable($value)) {
            $value = $value($this);
        }

        return $value;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value)
    {
        $this->storage->set($name, $value);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return $this->storage->has($name);
    }

    /**
     * @param string $name
     */
    public function remove($name)
    {
        $this->storage->remove($name);
    }

    /**
     * @param string $name
     * @param callable $callable
     */
    public function singleton($name, \Closure $callable)
    {
        $this->storage->set($name, function () use ($callable) {
            static $instance = null;

            if ($instance === null) {
                $instance = $callable($this);
            }

            return $instance;
        });
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return $this->has($name);
    }

    /**
     * @param string $name
     */
    public function __unset($name)
    {
        $this->remove($name);
    }
}
 