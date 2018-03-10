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
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Parser\Validator;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ListenerValidatorInterface;

/**
 * Abstract priority validator test
 *
 * This class is used to validate the AbstractPriorityValidator class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
abstract class AbstractPriorityValidatorTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\AbstractPriorityValidator::__construct
     * method
     *
     * @return void
     */
    public function testConstructor() : void
    {
        $this->assertConstructor(
            [
                'same:priorityValidator' => $this->createMock(ListenerValidatorInterface::class)
            ]
        );
    }

    /**
     * Test validatePriority
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\AbstractPriorityValidator::validatePriority
     * method
     *
     * @return void
     */
    public function testValidatePriority()
    {
        $instance = $this->getInstance();

        $method = $this->getClassMethod('validatePriority');

        $priorityValidator = $this->createMock(ListenerValidatorInterface::class);
        $priorityValidator->expects($this->once())
            ->method('isValid')
            ->with($this->equalTo([12]))
            ->willReturn(true);

        $this->getClassProperty('priorityValidator')->setValue($instance, $priorityValidator);

        $this->assertTrue($method->invoke($instance, [12]));
    }
}
