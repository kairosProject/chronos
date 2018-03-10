<?php
declare(strict_types=1);
/**
 * This file is part of the chronos project.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.2
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ApiBundle\Tests\Converter;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ApiBundle\Converter\GenericNameConverter;

/**
 * Gneric name converter test
 *
 * This class is used to validate the GenericNameConverter class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericNameConverterTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ApiBundle\Converter\GenericNameConverter::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $class = $this->getTestedClass();
        $emptyInstance = new $class();
        $emptyInstanceMap = $this->getClassProperty('nameMapping')->getValue($emptyInstance);

        $this->assertTrue(is_array($emptyInstanceMap));
        $this->assertEmpty($emptyInstanceMap);

        $content = ['property' => 'name'];
        $filledInstance = new $class($content);
        $filledInstanceMap = $this->getClassProperty('nameMapping')->getValue($filledInstance);

        $this->assertTrue(is_array($filledInstanceMap));
        $this->assertSame($content, $filledInstanceMap);
    }

    /**
     * Test denormalize
     *
     * Validate the Chronos\ApiBundle\Converter\GenericNameConverter::denormalize method
     *
     * @return void
     */
    public function testDenormalize()
    {
        $content = ['property' => 'name'];
        $instance = $this->getInstance();
        $this->getClassProperty('nameMapping')->setValue($instance, $content);

        $this->assertEquals('property', $instance->denormalize('name'));
        $this->assertEquals('otherName', $instance->denormalize('otherName'));
    }

    /**
     * Test normalize
     *
     * Validate the Chronos\ApiBundle\Converter\GenericNameConverter::normalize method
     *
     * @return void
     */
    public function testNormalize()
    {
        $content = ['property' => 'name'];
        $instance = $this->getInstance();
        $this->getClassProperty('nameMapping')->setValue($instance, $content);

        $this->assertEquals('name', $instance->normalize('property'));
        $this->assertEquals('otherName', $instance->normalize('otherName'));
    }

    /**
     * Get tested class
     *
     * Return the tested class name
     *
     * @return string
     */
    protected function getTestedClass() : string
    {
        return GenericNameConverter::class;
    }
}
