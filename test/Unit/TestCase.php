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
     * Get the value of a static attribute.
     *
     * @param string $attribute
     * @return void
     */
    public function getStatic($attribute)
    {
        $reflection = new ReflectionClass(static::$className);
        $property = $reflection->getStaticProperties();
        return $property[$attribute];
    }

    /**
     * Set the value of a static attribute.
     *
     * @param string $attribute
     * @param string $value
     * @return void
     */
    public function setStatic($attribute, $value)
    {
        $reflection = new ReflectionClass(static::$className);
        $property = $reflection->getProperty($attribute);
        $property->setAccessible(true);
        $property->setValue(null, $value);
    }

    /**
     * Set the value of a protected attribute.
     *
     * @param object $instance
     * @param string $attribute
     * @param string $value
     * @return void
     */
    public function setProtected($instance, $attribute, $value)
    {
        $reflection = new ReflectionClass($instance);
        $property = $reflection->getProperty($attribute);
        $property->setAccessible(true);
        $property->setValue($instance, $value);
    }

    /**
     * Get the value of a protected attribute.
     *
     * @param object $instance
     * @param string $attribute
     * @return void
     */
    public function getProtected($instance, $attribute)
    {
        $reflection = new ReflectionClass(static::$className);
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
     * Fire a protected method.
     *
     * @param mixed $stub
     * @param string $name
     * @param array $args
     * @return mixed
     */
    protected function callMethod($stub, $name, array $args)
    {
        $reflection = new ReflectionClass(static::$className);
        $method = $reflection->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($stub, $args);
    }
}
