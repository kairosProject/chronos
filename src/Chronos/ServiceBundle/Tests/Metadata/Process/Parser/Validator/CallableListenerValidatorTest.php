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

use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\CallableListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ListenerValidatorInterface;

/**
 * Callable listener validator test
 *
 * This class is used to validate the CallableListenerValidator class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class CallableListenerValidatorTest extends AbstractPriorityValidatorTest
{
    /**
     * Test isValid
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\CallableListenerValidator::isValid
     * method
     *
     * @return void
     */
    public function testIsValid()
    {
        $instance = $this->getInstance();

        $priorityValidator = $this->createMock(ListenerValidatorInterface::class);
        $priorityValidator->expects($this->exactly(2))
            ->method('isValid')
            ->withConsecutive($this->equalTo([12]), $this->equalTo([]))
            ->willReturn(true);

        $this->getClassProperty('priorityValidator')->setValue($instance, $priorityValidator);

        $this->assertTrue($instance->isValid([static::class, 'testIsValid', 12]));
        $this->assertTrue($instance->isValid([static::class, 'testIsValid']));
        $this->assertFalse($instance->isValid([static::class]));
        $this->assertFalse($instance->isValid([]));
        $this->assertFalse($instance->isValid([12]));
        $this->assertFalse($instance->isValid(['string']));
        $this->assertFalse($instance->isValid(['is_int']));
        $this->assertFalse($instance->isValid([static::class, 'fakeMethod']));
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
        return CallableListenerValidator::class;
    }
}

