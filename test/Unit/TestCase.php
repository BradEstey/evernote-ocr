<?php

namespace Estey\EvernoteOCR\Test\Unit;

use PHPUnit_Framework_TestCase;
use Mockery as m;
use ReflectionClass;

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Tear Down
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }


    /**
     * Set the value of a protected, private or static attribute.
     *
     * @param object $instance
     * @param string $attribute
     * @param mixed $value
     * @return void
     */
    public function setInaccessible($instance, $attribute, $value)
    {
        $reflection = new ReflectionClass($instance);
        $property = $reflection->getProperty($attribute);
        $property->setAccessible(true);
        $property->setValue($instance, $value);
    }

    /**
     * Get the value of a protected, private or static attribute.
     *
     * @param object $instance
     * @param string $attribute
     * @return mixed
     */
    public function getInaccessible($instance, $attribute)
    {
        $reflection = new ReflectionClass($instance);
        $properties = $reflection->getProperties();
        foreach ($properties as $property) {
            if ($property->getName() === $attribute) {
                $property->setAccessible(true);
                return $property->getValue($instance);
            }
        }
        return null;
    }

    /**
     * Fire a protected or private method.
     *
     * @param object $instance
     * @param string $name
     * @param array $args
     * @return mixed
     */
    protected function callInaccessibleMethod($instance, $name, array $args)
    {
        $reflection = new ReflectionClass($instance);
        $method = $reflection->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($instance, $args);
    }
}
