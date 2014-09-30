<?php

namespace frostealth\Container\tests;

use frostealth\Container\Container;

/**
 * Class ContainerTest
 *
 * @package frostealth\ContainerTest\tests
 */
class ContainerTest extends \PHPUnit_Framework_TestCase
{
    /** @var Container */
    private $container;

    public function setUp()
    {
        $this->container = new Container();
    }

    public function testSetAndGet()
    {
        $this->assertNull($this->container->get('unregistered'));

        $obj = $this->getMock('stdClass');

        $this->container->set('obj', $obj);
        $this->assertSame($obj, $this->container->get('obj'));

        $this->container->set('name', 'Robert');
        $this->container->set('obj', function (Container $locator) {
            $obj = $this->getMock('stdClass');
            $obj->name = $locator->get('name');

            return $obj;
        });

        $this->assertNotEquals($obj, $this->container->get('obj'));

        $obj->name = $this->container->get('name');

        $this->assertEquals($obj, $this->container->get('obj'));
        $this->assertNotSame($this->container->get('obj'), $this->container->get('obj'));
    }

    public function testHas()
    {
        $this->assertFalse($this->container->has('simple'));

        $this->container->set('simple', 'simple-def');
        $this->assertTrue($this->container->has('simple'));
    }

    public function testRemove()
    {
        $this->container->set('name', 'Robert');
        $this->container->remove('name');

        $this->assertFalse($this->container->has('name'));
    }

    public function testSingleton()
    {
        $this->container->set('string', 'example');

        $obj = $this->getMock('stdClass');
        $obj->string = 'example';

        $this->container->singleton('singleton', function (Container $Container) {
            $object = $this->getMock('stdClass');
            $object->string = $Container->get('string');

            return $object;
        });

        $this->assertEquals($obj, $this->container->get('singleton'));
        $this->assertSame($this->container->get('singleton'), $this->container->get('singleton'));

        $this->container->singleton('singleton', function () {
            return $this->getMock('stdClass');
        });

        $this->assertInstanceOf('stdClass', $this->container->get('singleton'));
        $this->assertNotEquals($obj, $this->container->get('singleton'));
    }
}
 