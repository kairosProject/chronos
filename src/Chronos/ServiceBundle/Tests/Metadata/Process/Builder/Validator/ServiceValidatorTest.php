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
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Builder\Validator;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Builder\Validator\ServiceValidator;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ServiceValidator test
 *
 * This class is used to validate the ServiceValidator class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ServiceValidatorTest extends AbstractTestClass
{
    /**
     * Test constructor
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\Validator\ServiceValidator::__construct method
     *
     * @return void
     */
    public function testConstructor() : void
    {
        $this->assertConstructor(
            [
                'same:container' => $this->createMock(ContainerBuilder::class)
            ]
        );

        return;
    }

    /**
     * Test isValid
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\Validator\ServiceValidator::isValid method
     *
     * @return void
     */
    public function testIsValid()
    {
        $container = $this->createMock(ContainerBuilder::class);
        $this->getInvocationBuilder($container, $this->exactly(4), 'has')
            ->withConsecutive(
                $this->equalTo('undefined'),
                $this->equalTo('undefined'),
                $this->equalTo('defined'),
                $this->equalTo('defined')
            )->willReturnOnConsecutiveCalls(
                false,
                false,
                true,
                true
            );

        $instance = $this->getInstance();
        $this->getClassProperty('container')->setValue($instance, $container);

        $this->assertFalse($instance->isValid('undefined'));
        $this->assertFalse($instance->isValid('@undefined'));
        $this->assertTrue($instance->isValid('defined'));
        $this->assertTrue($instance->isValid('@defined'));
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
        return ServiceValidator::class;
    }
}
