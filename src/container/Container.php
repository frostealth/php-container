<?php

namespace frostealth\container;

use frostealth\container\exceptions\ContainerException;
use frostealth\storage\Data;
use frostealth\storage\DataInterface;
use Interop\Container\ContainerInterface;

/**
 * Class Container
 *
 * @package frostealth\container
 */
class Container implements ContainerInterface
{
    /**
     * @var DataInterface
     */
    protected $storage;

    /**
     * @param array|DataInterface $values
     */
    public function __construct($values = [])
    {
        if (is_array($values)) {
            $values = new Data($values);
        }

        if (!$values instanceof DataInterface) {
            throw new ContainerException('Expected a DataInterface');
        }

        $this->storage = $values;
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
            $value = call_user_func($value, $this);
        }

        return $value;
    }

    /**
     * @param string $name
     * @param mixed  $value
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
     * Ensure a value or object will remain globally unique
     *
     * @param string   $name
     * @param callable $callable
     */
    public function singleton($name, callable $callable)
    {
        $this->storage->set($name, function () use ($callable) {
            static $instance = null;

            if ($instance === null) {
                $instance = call_user_func($callable, $this);
            }

            return $instance;
        });
    }

    /**
     * Protect closure from being directly invoked
     *
     * @param string   $name
     * @param callable $callable
     */
    public function protect($name, callable $callable)
    {
        $this->storage->set($name, function () use ($callable) {
            return $callable;
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
     * @param mixed  $value
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
 