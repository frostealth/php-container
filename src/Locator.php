<?php

namespace frostealth\Locator;

use frostealth\Storage\Data;

/**
 * Class Locator
 *
 * @package frostealth\Locator
 */
class Locator
{
    /** @var Data */
    protected $container;

    public function __construct()
    {
        $this->container = new Data();
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function get($name)
    {
        $value = $this->container->get($name);
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
        $this->container->set($name, $value);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return $this->container->has($name);
    }

    /**
     * @param string $name
     */
    public function remove($name)
    {
        $this->container->remove($name);
    }

    /**
     * @param string $name
     * @param callable $value
     */
    public function singleton($name, \Closure $value)
    {
        $this->container->set($name, function () use ($value) {
            static $instance = null;

            if ($instance === null) {
                $instance = $value($this);
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
 