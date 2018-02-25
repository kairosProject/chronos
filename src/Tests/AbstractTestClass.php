<?php
declare(strict_types=1);
/**
 * This file is part of the chronos project.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 5.6
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace App\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Abstract test class
 *
 * This class is used as placeholder for test implementation
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
abstract class AbstractTestClass extends TestCase
{
    /**
     * Class reflection
     *
     * The tested class reflection to be stored and used during test
     *
     * @var \ReflectionClass
     */
    protected $classReflection;

    /**
     * Setup
     *
     * This method is called before each test.
     *
     * @see    \PHPUnit\Framework\TestCase::setUp()
     * @return void
     */
    protected function setUp()
    {
        $this->classReflection = new \ReflectionClass($this->getTestedClass());
    }

    /**
     * Get class property
     *
     * Return an instance of ReflectionProperty for a given property name
     *
     * @param string $property   The property name to reflex
     * @param bool   $accessible The accessibility state of the property
     *
     * @return \ReflectionProperty
     */
    protected function getClassProperty(string $property, bool $accessible = true)
    {
        $this->assertTrue(
            $this->classReflection->hasProperty($property),
            sprintf(
                'The class "%s" is expected to store the property "%s"',
                $this->getTestedClass(),
                $property
            )
        );
        $property = $this->classReflection->getProperty($property);
        $property->setAccessible($accessible);

        return $property;
    }

    /**
     * Get instance
     *
     * Return an instance of tested class without constructor call
     *
     * @return object
     */
    protected function getInstance()
    {
        return $this->classReflection->newInstanceWithoutConstructor();
    }

    /**
     * Assert is simple getter
     *
     * Validate the given method is a simple getter method and return the given value from the given property
     *
     * @param string $property The property name
     * @param string $method   The getter method
     * @param mixed  $value    The returned value
     *
     * @return void
     */
    protected function assertIsSimpleGetter(string $property, string $method, $value) : void
    {
        $propertyReflex = $this->getClassProperty($property);

        $instance = $this->getInstance();
        $propertyReflex->setValue($instance, $value);

        $this->assertEquals($value, $instance->{$method}());

        return;
    }

    /**
     * Get tested class
     *
     * Return the tested class name
     *
     * @return string
     */
    abstract protected function getTestedClass() : string;
}
